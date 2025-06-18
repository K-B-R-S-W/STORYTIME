from fastapi import FastAPI, Request
from fastapi.responses import HTMLResponse, JSONResponse
from fastapi.middleware.cors import CORSMiddleware
from langgraph.checkpoint.memory import MemorySaver
from langgraph.graph import START, MessagesState, StateGraph
from langchain_groq import ChatGroq
from langchain_core.messages import HumanMessage, SystemMessage
from groq import Groq, APIError # Import APIError for specific error handling
import os
import socket
import uvicorn
import re
import logging # Import logging
from pydantic import SecretStr

# Setup basic logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = FastAPI()

# --- CORS Configuration Start ---
# Function to get local IP (already provided in your original code)
def get_local_ip():
    local_ip = "127.0.0.1" # Default to localhost
    try:
        s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
        # Doesn't have to be reachable
        s.connect(("8.8.8.8", 80))
        ip = s.getsockname()[0]
        s.close()
        # Ensure it's not a loopback or docker internal IP if expecting external access
        # This basic check might need adjustment depending on network setup
        if not ip.startswith('172.'): # Simple check, might need refinement
             local_ip = ip
    except Exception as e:
        logger.warning(f"Could not detect non-loopback IP, defaulting to 127.0.0.1: {e}")
    return local_ip

# Define allowed origins explicitly
host_ip = get_local_ip()
allowed_origins = [
    "http://localhost",
    "http://127.0.0.1",
    "http://localhost:8000",
    "http://127.0.0.1:8000",
    f"http://{host_ip}",
    f"http://{host_ip}:8000",
    "*"  # Allow all origins for testing
]

logger.info(f"Allowed Origins for CORS: {allowed_origins}")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # Allow all origins
    allow_credentials=True,
    allow_methods=["*"],  # Allow all methods including OPTIONS
    allow_headers=["*"],  # Allow all headers
    expose_headers=["*"]  # Expose all headers
)
# --- CORS Configuration End ---

# Set up Groq API key (now only from environment variable)
groq_api_key = os.environ.get("GROQ_API_KEY")
if not groq_api_key:
    logger.error("GROQ_API_KEY not set. Please set it in your .env file or environment.")
    raise ValueError("GROQ_API_KEY not set")

groq_api_key_secret = SecretStr(groq_api_key)

# Initialize Groq clients
try:
    groq_client = Groq(api_key=groq_api_key)
    model = ChatGroq(model="llama3-8b-8192", api_key=groq_api_key_secret)
except Exception as e:
    logger.error(f"Failed to initialize Groq clients: {e}")
    raise

# Define the system prompt
system_prompt = """You are StoryTime AI, a helpful assistant for the StoryTime movie booking website. Your primary goal is to assist users with movie bookings and provide information about our available movies.

Available Movies:
1. Oppenheimer
2. The Family Plan
3. John Wick
4. Black Panther
5. Chicken Run
6. Black Adam
7. Avatar 2
8. Barbie

Key Responsibilities:
1. Movie Information: Only provide details about the movies listed above. Do not recommend or discuss movies that are not in our system.
2. Booking Assistance: Help users with the booking process, seat selection, and payment procedures.
3. Theater Information: Share details about theater facilities, seating arrangements, and amenities.
4. Special Offers: Inform users about ongoing promotions and discounts.

Guidelines:
1. ONLY discuss and recommend movies from the above list. Never suggest movies that aren't in our system.
2. If users ask about other movies, politely inform them that those movies are not currently available in our theater.
3. Be friendly and enthusiastic about our available movies.
4. Provide accurate information about showtimes and theater facilities.
5. Help users navigate the booking process.

Example interactions:
User: "What movies do you have?"
Assistant: "We currently have these amazing movies showing at StoryTime:
- Oppenheimer: Christopher Nolan's epic biographical thriller
- The Family Plan: Action-packed family adventure
- John Wick: High-octane action thriller
- Black Panther: Marvel superhero epic
- Chicken Run: Delightful animated adventure
- Black Adam: DC superhero action
- Avatar 2: James Cameron's spectacular sci-fi sequel
- Barbie: Magical adventure with the world's favorite doll

Would you like to know more about any of these movies or help with booking tickets?"

User: "Tell me about a movie not in this list"
Assistant: "I apologize, but that movie is not currently showing at StoryTime. However, I'd be happy to tell you about our current movies or help you book tickets for any of our available shows."
"""

# LangGraph State and Workflow
class VoiceAppState(MessagesState):
    pass

def call_model(state: VoiceAppState):
    logger.info(f"Calling model with messages: {state['messages']}")
    messages = [SystemMessage(content=system_prompt)] + state["messages"]
    try:
        response = model.invoke(messages)
        logger.info(f"Model response received: {response.content}")
        return {"messages": [response]} # Return only the AI response message
    except Exception as e:
        logger.error(f"Error invoking the language model: {e}")
        error_message = "Sorry, I encountered an error trying to process that. Please try again."
        # Return an AIMessage indicating the error
        return {"messages": [SystemMessage(content=error_message)]}

workflow = StateGraph(VoiceAppState)
workflow.add_node("model", call_model)
workflow.set_entry_point("model")
workflow.set_finish_point("model") # Simple graph: model calls itself conceptually

memory = MemorySaver()
# Checkpointer configuration might be needed for actual memory persistence
graph = workflow.compile(checkpointer=memory)

# Helper Functions for Response Formatting
def clean_response(text):
    """Remove Markdown bold markers (**) and potential unwanted artifacts."""
    return text.replace("**", "").strip()

def format_response_as_list(response_text):
    """Analyzes response text and formats it appropriately (steps or plain text)."""
    cleaned_text = clean_response(response_text)

    # Regex to find lines starting with numbers/dots or "Step X:"
    step_pattern = r'^\s*(\d+\.|Step\s*\d+\s*[:-]?)\s+'
    lines = cleaned_text.split('\n')
    steps = []
    is_list_format = False

    for line in lines:
        line = line.strip()
        if re.match(step_pattern, line):
            is_list_format = True
            # Extract the text after the step marker
            step_text = re.sub(step_pattern, '', line)
            if step_text: # Only add if there's content
                steps.append(step_text)
        elif is_list_format and line:
             # If already in list format, append subsequent non-empty lines
             steps.append(line)
        elif line:
             steps.append(line)

    # Decide final format
    if is_list_format and len(steps) > 1:
        steps = [s.strip() for s in steps if s.strip()]
        return {"type": "steps", "content": steps}
    else:
        final_text = "\n".join(steps).strip()
        if not final_text:
             return {"type": "text", "content": "..."}
        return {"type": "text", "content": final_text}

@app.post("/chat")
async def chat(request: Request):
    """Handle text chat requests."""
    try:
        data = await request.json()
        user_message = data.get("message", "").strip()
        if not user_message:
            return JSONResponse(
                content={"error": "No message provided"},
                status_code=400
            )
        # Use LangGraph for response generation
        response = graph.invoke(
            {"messages": [HumanMessage(content=user_message)]}
        )
        # Extract and format the response
        ai_message = response["messages"][-1].content
        formatted_response = format_response_as_list(ai_message)
        return JSONResponse(content=formatted_response)
    except Exception as e:
        logger.error(f"Error in chat endpoint: {e}", exc_info=True)
        return JSONResponse(
            content={"error": "An error occurred processing your request"},
            status_code=500
        )

@app.get("/", response_class=HTMLResponse)
async def read_root():
    """Serve a simple HTML page for testing the chat functionality."""
    return """
    <!DOCTYPE html>
    <html>
    <head>
        <title>Emergency Assistant Chat</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            #chat-container { max-width: 600px; margin: auto; }
            #messages { height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
            #input-container { display: flex; }
            #user-input { flex-grow: 1; padding: 5px; margin-right: 5px; }
            .message { margin-bottom: 10px; }
            .user-message { color: blue; }
            .assistant-message { color: green; }
        </style>
    </head>
    <body>
        <div id="chat-container">
            <div id="messages"></div>
            <div id="input-container">
                <input type="text" id="user-input" placeholder="Type your message...">
                <button onclick="sendMessage()">Send</button>
            </div>
        </div>

        <script>
            async function sendMessage() {
                const input = document.getElementById('user-input');
                const message = input.value.trim();
                if (!message) return;

                // Display user message
                displayMessage('You: ' + message, 'user-message');
                input.value = '';

                try {
                    const response = await fetch('/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ message: message })
                    });

                    const data = await response.json();
                    
                    // Handle different response formats
                    if (data.type === 'steps') {
                        const steps = data.content.map((step, index) => 
                            `${index + 1}. ${step}`
                        ).join('\\n');
                        displayMessage('Assistant:\\n' + steps, 'assistant-message');
                    } else {
                        displayMessage('Assistant: ' + data.content, 'assistant-message');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    displayMessage('Error: Failed to get response', 'error-message');
                }
            }

            function displayMessage(message, className) {
                const messagesDiv = document.getElementById('messages');
                const messageElement = document.createElement('div');
                messageElement.className = 'message ' + className;
                messageElement.innerText = message;
                messagesDiv.appendChild(messageElement);
                messagesDiv.scrollTop = messagesDiv.scrollHeight;
            }

            // Allow sending message with Enter key
            document.getElementById('user-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });
        </script>
    </body>
    </html>
    """

if __name__ == "__main__":
    uvicorn.run(app, host="0.0.0.0", port=8000)