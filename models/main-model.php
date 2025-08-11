<?php 
/**
 * Builds a navigation menu list from the provided navigation data.
 *
 * @param array $navs An array containing navigation items with 'name' and 'navId'.
 * @return string HTML unordered list of navigation links.
 */
function buildNavList($navs) {
    // Start the unordered list
    $navList = '<ul>';
    
    // Loop through each navigation item
    foreach ($navs as $nav) {
        // Add each navigation link with its corresponding action parameter
        $navList .= "<li><a href='/worksafe/index.php?action=" . urlencode($nav['name']) .
        "' title='View our $nav[name] '>$nav[name]</a> </li>";
    }
    
    // Close the unordered list
    $navList .= '</ul>';
 
    // Return the complete HTML list
    return $navList;
}
?>
