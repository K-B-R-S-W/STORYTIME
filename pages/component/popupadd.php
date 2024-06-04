<div class="button-add-Movie">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add Movie</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Movie</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <form method="POST" action="addmovie.php" enctype="multipart/form-data">
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">img:</label>
                                    <input type="file" class="form-control" id="recipient-name" accept=".jpg,.png,.jpeg" name="img">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Title">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Genre:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Genre">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Duration:</label>
                                    <input type="text" class="form-control" id="recipient-name" name="Duration">
                                  </div>
                                  <div class="">
                                    <label for="recipient-name" class="col-form-label">Release Date:</label>
                                    <input type="date" class="form-control" id="recipient-name" name="ReleaseDate">
                                  </div>
                                  <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name="submit" class="btn btn-primary">Add Movie</button>
                              </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>