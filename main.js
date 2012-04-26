            function sleep(milliseconds) {
		  var start = new Date().getTime();
		  for (var i = 0; i < 1e7; i++) {
		    if ((new Date().getTime() - start) > milliseconds){
		      break;
		    }
		  }
	    }

            (function ($) {
 
                // We'll use this to cache the progress bar node
                var pbar;
 
                // This flag determines if the upload has started
                var started = false;
 
                $(function () {
 
                    // Start progress tracking when the form is submitted
                    $('#upload-form').submit(function() {
 
                        // Hide the form
                        $('#upload-form').hide();
 
                        // Cache the progress bar
                        pbar = $('#progress-bar');
 
                        // Show the progress bar
                        // Initialize the jQuery UI plugin
                        pbar.show().progressbar();
 
                        // We know the upload is complete when the frame loads
                        $('#upload-frame').load(function () {
 
                            // This is to prevent infinite loop
                            // in case the upload is too fast
                            started = true;
 
                            // Do whatever you want when upload is complete
			    alert('Upload Complete!');
			    sleep(2);
                            window.location = "index.php";
 
                        });
 
                        // Start updating progress after a 1 second delay
                        setTimeout(function () {
 
                            // We pass the upload identifier to our function
                            updateProgress($('#uid').val());
 
                        }, 1000);
 
                    });
 
                });
 
                function updateProgress(id) {
 
                    var time = new Date().getTime();
 
                    // Make a GET request to the server
                    // Pass our upload identifier as a parameter
                    // Also pass current time to prevent caching
                    $.get('./getprogress.php', { uid: id, t: time }, function (data) {
 
                        // Get the output as an integer
                        var progress = parseInt(data, 10);
 
                        if (progress < 100 || !started) {
 
                            // Determine if upload has started
                            started = progress < 100;
 
                            // If we aren't done or started, update again
                            updateProgress(id);
 
                        }
 
                        // Update the progress bar percentage
                        // But only if we have started
                        started && pbar.progressbar('value', progress);
 
                    });
 
                }
 
            }(jQuery));
