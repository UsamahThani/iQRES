let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
        let cameras = [];

        function startScanner(camera) {
            scanner.start(camera).then(function() {
                if (camera.name.includes("back")) {
                    scanner.mirror = false; // Disable mirroring for back camera
                } else {
                    scanner.mirror = true;  // Enable mirroring for front camera
                }
                
                // Enable autofocus
                scanner.camera.applyConstraints({ advanced: [{ autoFocus: 'continuous' }] });
                
                // Allow user to click to focus
                document.getElementById('preview').addEventListener('click', function() {
                    scanner.camera.applyConstraints({ advanced: [{ focusMode: 'auto' }] });
                });
            }).catch(function(e) {
                console.error(e);
            });
        }

        Instascan.Camera.getCameras().then(function(cameras) {
            if (cameras.length > 0) {
                cameras.forEach(function(camera, index) {
                    const option = document.createElement("option");
                    option.value = index;
                    option.text = camera.name;
                    document.getElementById('cameraSelection').appendChild(option);
                });
                
                // Find the back camera if available
                const backCamera = cameras.find(camera => camera.name.includes("back"));
                
                // Start with the back camera by default if available, else start with the first camera
                startScanner(backCamera || cameras[0]);
                
                document.getElementById('cameraSelection').addEventListener('change', function() {
                    const selectedCameraIndex = this.value;
                    const selectedCamera = cameras[selectedCameraIndex];
                    startScanner(selectedCamera);
                });
            } else {
                alert("No cameras found");
            }
        }).catch(function(e) {
            console.error(e);
        });

        scanner.addListener('scan', function(c) {
            document.getElementById('text').value = c;

            // Send the scanned QR code text to the PHP script
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'user_equipment_borrowReturn.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText); // Response from the server
                        // Wait for the AJAX request to complete, then redirect
                        location.href = "user_equipment_borrowReturn.php?qrText=" + encodeURIComponent(c);
                    } else {
                        console.error('Error:', xhr.status);
                    }
                }
            };
            const formData = new FormData();
            formData.append('qrCodeText', c);
            xhr.send(formData);
        });
