<?php

// Function to retrieve navigation items from the database
function getNavs() {
    // Connect to the database using the "dataPrueba" connection function
    $db = dataPrueba(); 
    
    // SQL query to select name and navId from the nav table
    // Ordered so that "Home" appears first, "Login" appears third,
    // and all other items appear in alphabetical order in between
    $sql = 'SELECT name, navId FROM nav 
            ORDER BY 
                CASE 
                    WHEN name = "Home" THEN 0 
                    WHEN name = "Login" THEN 2 
                    ELSE 1 
                END, 
                name ASC'; 
    
    // Prepare the SQL statement for execution
    $stmt = $db->prepare($sql);
    
    // Execute the SQL statement
    $stmt->execute(); 
    
    // Fetch all the results as an associative array
    $classnav = $stmt->fetchAll(); 
    
    // Close the cursor to free up the connection
    $stmt->closeCursor(); 
    
    // Return the list of navigation items
    return $classnav;
}
