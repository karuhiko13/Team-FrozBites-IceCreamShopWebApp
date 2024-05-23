<?php
    if (isset($success_msg)) { // Checking if success messages exist
        foreach ($success_msg as $success_msg) { // Looping through each success message
            echo '<script>swal("'.$success_msg.'","", "success"); </script>'; // Displaying success message using SweetAlert
        }
    }
    if (isset($warning_msg)) { // Checking if warning messages exist
        foreach ($warning_msg as $warning_msg) { // Looping through each warning message
            echo '<script>swal("'.$warning_msg.'", "", "warning"); </script>'; // Displaying warning message using SweetAlert
        }
    }
    if (isset($info_msg)) { // Checking if info messages exist
        foreach ($info_msg as $info_msg) { // Looping through each info message
            echo '<script>swal("'.$info_msg.'", "", "info"); </script>'; // Displaying info message using SweetAlert
        }
    }
    if (isset($error_msg)) { // Checking if error messages exist
        foreach ($error_msg as $error_msg) { // Looping through each error message
            echo '<script>swal("'.$error_msg.'", "", "error");</script>'; // Displaying error message using SweetAlert
        }
    }   
?>
