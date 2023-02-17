<?php require 'header.php' ?>

        <div class="row">
            <div class="col">
        
                <p>Fill out the form below to submit your UFO sighting
                - <?php echo getDateInDutch()?>
                </p>

                <form method="post" action="process.php" enctype="multipart/form-data">
                    <input class='form-control' type="text" name="name" placeholder="Name"><hr>
                    <input class='form-control' type="email" name="email" placeholder="Email"><hr>
                    <input class='form-control' type="text" name="location" placeholder="Location"><hr>
                    <input class='form-control' type="date" name="date" placeholder="Date"><hr>
                    <input class='form-control' type="time" name="time" placeholder="Time"><hr>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="scary">
                          Does the alien look scary?
                    </div>
                    <textarea class='form-control' name="message"></textarea><br>
                    <input class="form-control" type="file" name="alienImg"><hr>
                    <input class='btn btn-primary' type="submit" value="Submit">
                </form>
            </div>
        </div>

 <?php require 'footer.php' ?>