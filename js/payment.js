const stripe = Stripe('pk_test_51ONqU9CfR0hpy84b4CwDUZjfjTBhiDs3jj6pq2QtpAY535ZEeWwY4ZheWqW2kcoCxZymOy9Rgj1tU5hO6XssTfIw00CMQKkiU1'); // Replace with your Stripe publishable key

async function processBooking() {
  const name = document.getElementById('nameDisplay').value; // Fetch the name
  const numberOfSeats = document.getElementById('NumberDisplay').value; // Fetch number of seats
  const selectedSeats = document.getElementById('seatsDisplay').value; // Fetch selected seats

  try {
    // Create a payment intent or retrieve client secret from your server
    const response = await fetch('/create-payment-intent', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        amount: 530,
        // You can include additional data here for payment processing
      }),
    });
    const { clientSecret } = await response.json();

    // Use Stripe Elements or collect card details from the user
    const { error } = await stripe.confirmCardPayment(clientSecret, {
      payment_method: {
        card: /* obtain card details from user input or Stripe Elements */,
        // You can add billing details, setup_future_usage, etc. as needed
      },
    });

    if (error) {
      // Handle payment error (e.g., display error message to the user)
      console.error('Payment failed:', error.message);
    } else {
      // Payment successful, proceed with booking confirmation or other actions
      console.log('Payment successful!');
      // Perform further booking confirmation steps here
    }
  } catch (err) {
    // Handle errors that might occur during payment processing
    console.error('Error:', err);
  }
}


const express = require('express');
const app = express();
const stripe = require('stripe')('sk_test_51ONqU9CfR0hpy84beGdDj5sovfh30lz5J4hTUhShhzdhmE23g4n0QBJHc7yTLr7w7vJSV4n9Ojt4u5HG1yObWTQK00TGll00T4'); // Replace with your actual Stripe secret key

app.use(express.json());

app.post('/create-payment-intent', async (req, res) => {
  try {
    const { amount, currency } = req.body;

    // Create a payment intent with Stripe
    const paymentIntent = await stripe.paymentIntents.create({
      amount: 530,
    });

    res.status(200).json({ clientSecret: paymentIntent.client_secret });
  } catch (err) {
    res.status(500).json({ error: err.message });
  }
});

// Start the server
const PORT = process.env.PORT || 4242;
app.listen(PORT, () => {
  console.log(`Server running on port ${4242}`);
});
