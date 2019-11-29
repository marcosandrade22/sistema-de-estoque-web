
    <div class="container margin-top" >
         <h3><?php echo $pagina ?></h3>
        <br />
<?php
    // The unzip script
    // Created by Alex at http://www.learncpp.com
    //
    // This script lists all of the .zip files in a directory
    // and allows you to select one to unzip.  Unlike CPanel's file
    // manager, it _will_ overwrite existing files.
    //
    // To use this script, FTP or paste this script into a file in the directory
    // with the .zip you want to unzip.  Then point your web browser at this
    // script and choose which file to unzip.
 
    // See if there's a file parameter in the URL string
    $file = $_GET['file'];
 
    if (isset($file))
    {
       echo "Unzipping " . $file . "<br>";
       system('unzip -o ' . $file);
       exit;
    }
 
    // create a handler to read the directory contents
    $handler = opendir(".");
 
    echo "Please choose a file to unzip: " . "<br>";
 
    // A blank action field posts the form to itself
    echo '<FORM action="" method="get">';
 
    $found = FALSE; // Used to see if there were any valid files
 
    // keep going until all files in directory have been read
    while ($file = readdir($handler))
    {
        if (preg_match ("/.zip$/i", $file))
        {
            echo '<input type="radio" name="file" value=' . $file . '> ' . $file . '<br>';
            $found = true;
        }
    }
 
    closedir($handler);
 
    if ($found == FALSE)
        echo "No files ending in .zip found<br>";
    else
        echo '<br>Warning: Existing files will be overwritten.<br><br><INPUT type="submit" value="Unzip!">';
 
    echo "</FORM>";
?>
    </div>