<?php
    $IMGUR_CLIENT_ID = "47a63e89132418c";

    function imgurLink($imageFile) {
        global $IMGUR_CLIENT_ID;

        $status = 'danger';
        $imgurData = array();
        $valErr = "";

        if (empty($imageFile)) {
            echo "<script>alert('Please select a file to upload.');</script>";
            return false;
        }

        $fileName = basename($imageFile["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

        $allowTypes = array("jpg", "png", "jpeg", "gif");
        if (in_array($fileType, $allowTypes)) {
            $image_source = file_get_contents($imageFile["tmp_name"]);
            $postFields = array('image' => base64_encode($image_source));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $IMGUR_CLIENT_ID));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                echo "<script>alert('Curl error: " . curl_error($ch) . "');</script>";
            }

            curl_close($ch);

            $responseArr = json_decode($response);

            if (!empty($responseArr->data->link)) {
                $imgurData = $responseArr;
                $status = 'success';
                return $responseArr->data->link;
            } else {
                echo "<script>alert('The image upload failed.');</script>";
                return false;
            }
        } else {
            echo "<script>alert('Sorry, only an image file is allowed to upload.'); history.back();</script>";
            return false;
        }
    }

    function ImageFileToImgur($equipID) {
        global $IMGUR_CLIENT_ID;
        // Imgur API endpoint for image upload
        $apiEndpoint = 'https://api.imgur.com/3/image';

        // Image to upload
        $imagePath = 'temp_qrimage/equipQR_'.$equipID.'.png';

        // Set headers for authorization and content type
        $headers = array(
            'Authorization: Client-ID ' . $IMGUR_CLIENT_ID,
        );

        // Prepare image data
        $imageData = array(
            'image' => base64_encode(file_get_contents($imagePath)),
        );

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiEndpoint);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $imageData);

        // Execute cURL session
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);

        // Decode the JSON response
        $result = json_decode($response, true);

        // Check if the upload was successful
        if ($result && isset($result['data']['link'])) {
            if (file_exists($imagePath)) {
                // Attempt to delete the file
                if (unlink($imagePath)) {
                    echo '<script>alert("Image uploaded to Imgur successfully. Link: Imgur link: ' . $result['data']['link']. '");</script>';
                } else {
                    echo '<script>alert("Error deleting file.");</script>';
                }
            } else {
                echo '<script>alert("File does not exist.");</script>';
            }
        } else {
            echo '<script>alert("File does not exist. Error: '. $result['data']['error'].'");</script>';
        }
        return $result['data']['link'];
    }

    function DownloadImgur($imgurLink, $equipID) {
        $client_id = '59d303a71324926';
        $client_secret = '9da2a213d0b939bb62704bcc93302a4b173eac31';
        $access_token = '3a5212b918f6191578f19684b2331e2fa00269d2';
        $url = $imgurLink;
        $image_id = pathinfo($url, PATHINFO_FILENAME);

        // Make API request to get image data
        $api_url = "https://api.imgur.com/3/image/$image_id";
        $ch = curl_init($api_url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        // Parse the JSON response
        $data = json_decode($response, true);

        // Check if the request was successful
        if ($data['success']) {
            // Image URL
            $imageUrl = $data['data']['link'];

            // Download the image
            $imageData = file_get_contents($imageUrl);

            // Set headers to prompt download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$equipID.'.png"');

            // Output image data directly
            echo $imageData;
            exit; // Make sure nothing else is sent after the image data
        } else {
            echo 'Error downloading image: ' . $data['data']['error'];
        }
    }
?>