<style type="text/css">
    <!--
    .style1 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    .style2 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
    }
    .style3 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight:bold;
        color:#303030;
    }
    body {
        background-image: url(themes/default/images/background.gif);
    }
    -->
</style>

<script language="javascript">
    function NoConfirm ()
    {
        win = top;
        win.opener = top;
        win.close ();
    }

</script>

<p class="style1">
    <?php
    //define a maxim size for the uploaded images in Kb
    define ("MAX_SIZE","300");

    //This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    //This variable is used as a flag. The value is initialized with 0 (meaning no error  found)
    //and it will be changed to 1 if an error occures.
    //If the error occures the file will not be uploaded.
    $errors=0;
    //checks if the form has been submitted
    if(isset($_POST['Submit']))
    {
        //reads the name of the file the user submitted for uploading
        $image=$_FILES['image']['name'];
        //if it is not empty
        if ($image)
        {
            //get the original name of the file from the clients machine
            $filename = stripslashes($_FILES['image']['name']);
            //get the extension of the file in a lower case format
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            //if it is not a known extension, we will suppose it is an error and will not  upload the file,
            //otherwise we will do more tests
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))
            {
                //print error message
                echo 'Unknown extension!';
                $errors=1;
            }
            else
            {
//get the size of the image in bytes
                //$_FILES['image']['tmp_name'] is the temporary filename of the file
                //in which the uploaded file was stored on the server
                $size=filesize($_FILES['image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
                if ($size > MAX_SIZE*1024)
                {
                    echo 'You have exceeded the size limit!';
                    $errors=1;
                }

//we will give an unique name, for example the time in unix time format
                $image_name=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
                $newname="shareimg/".$image_name;
//we verify if the image has been uploaded, and print error instead
                $copied = copy($_FILES['image']['tmp_name'], $newname);
                if (!$copied)
                {
                    echo 'Copy unsuccessfull!';
                    $errors=1;
                }}}}

    //If no errors registred, print the success message
    if(isset($_POST['Submit']) && !$errors)
    {

//$host = $_SERVER['HTTP_HOST'];

/// for testing
//$host=$host . "/";

        echo "<img src=themes/default/images/check.png border=0 align=absmiddle>";

        echo "File Uploaded<br><br>(1) Copy<br><br>Hold the mouse button down and drag along the ENTIRE new image address, shown just below. It's called "selecting". Then press Ctrl-C keys to copy the new address:<br><br>";
echo "<table><tr><td bgcolor=f8f8f8><span class=style3>[img][]" .$newname. "[][/img]</span></td></tr></table>";
echo "<br><br>(2) Paste:<br>Back on the Chat page, click to type in the box, and paste the link by using the Ctrl-V keys<p><br>";

list($width) = getimagesize($newname);
if ($width <= 320) {
    $width=$width;
    $t = "<span class=style2>Image shown above</span><p></p>";
    $insert="[img][]" .$newname. "[][/img]";
} else {
    $width = "320";
    $t = "<span class=style2>Thumbnail image shown above</span><p></p>";
    $insert="[img][]" .$newname. "" "width=" .$width. "[][/img]";
}

echo "<img src=themes/default/images/check.png border=0 align=absmiddle>";

    echo "File Uploaded<br><br>(1) Copy<br><br>Hold the mouse button down and drag along the ENTIRE new image address, shown just below. It's called "selecting". Then press Ctrl-C keys to copy the new address:<br><br>";
echo "<table><tr><td bgcolor=f8f8f8><span class=style3>" . $insert . "</span></td></tr></table>";
echo "<br><br>(2) Paste:<br>Back on the Chat page, click to type in the box, and paste the link by using the Ctrl-V keys<p><br>";

echo "<img src=" .$newname. " width=" .$width. "><br>";
echo $t;
echo "<br><br>";
echo "<a href="javascript:NoConfirm()" style class="style2"><img src=themes/default/images/tab_remove.gif align=absmiddle border=0>  Close this window</a> </p>";
exit;

 }
    ?>
</p>

<style type="text/css">
    <!--
    .style1 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }
    .style2 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
    }
    .style3 {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        font-weight:bold;
        color:#303030;
    }
    body {
        background-image: url(themes/default/images/background.gif);
    }
    -->
</style>

<script language="javascript">
    function NoConfirm ()
    {
        win = top;
        win.opener = top;
        win.close ();
    }

</script>

<p class="style1">
    <?php
    //define a maxim size for the uploaded images in Kb
    define ("MAX_SIZE","300");

    //This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
    function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    //This variable is used as a flag. The value is initialized with 0 (meaning no error  found)
    //and it will be changed to 1 if an error occures.
    //If the error occures the file will not be uploaded.
    $errors=0;
    //checks if the form has been submitted
    if(isset($_POST['Submit']))
    {
        //reads the name of the file the user submitted for uploading
        $image=$_FILES['image']['name'];
        //if it is not empty
        if ($image)
        {
            //get the original name of the file from the clients machine
            $filename = stripslashes($_FILES['image']['name']);
            //get the extension of the file in a lower case format
            $extension = getExtension($filename);
            $extension = strtolower($extension);
            //if it is not a known extension, we will suppose it is an error and will not  upload the file,
            //otherwise we will do more tests
            if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif"))
            {
                //print error message
                echo 'Unknown extension!';
                $errors=1;
            }
            else
            {
//get the size of the image in bytes
                //$_FILES['image']['tmp_name'] is the temporary filename of the file
                //in which the uploaded file was stored on the server
                $size=filesize($_FILES['image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
                if ($size > MAX_SIZE*1024)
                {
                    echo 'You have exceeded the size limit!';
                    $errors=1;
                }

//we will give an unique name, for example the time in unix time format
                $image_name=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images folder)
                $newname="shareimg/".$image_name;
//we verify if the image has been uploaded, and print error instead
                $copied = copy($_FILES['image']['tmp_name'], $newname);
                if (!$copied)
                {
                    echo 'Copy unsuccessfull!';
                    $errors=1;
                }}}}

    //If no errors registred, print the success message
    if(isset($_POST['Submit']) && !$errors)
    {

//$host = $_SERVER['HTTP_HOST'];

/// for testing
//$host=$host . "/";

        echo "<img src=themes/default/images/check.png border=0 align=absmiddle>";

        echo "File Uploaded<br><br>(1) Copy<br><br>Hold the mouse button down and drag along the ENTIRE new image address, shown just below. It's called "selecting". Then press Ctrl-C keys to copy the new address:<br><br>";
echo "<table><tr><td bgcolor=f8f8f8><span class=style3>[img][]" .$newname. "[][/img]</span></td></tr></table>";
echo "<br><br>(2) Paste:<br>Back on the Chat page, click to type in the box, and paste the link by using the Ctrl-V keys<p><br>";

list($width) = getimagesize($newname);
if ($width <= 320) {
    $width=$width;
    $t = "<span class=style2>Image shown above</span><p></p>";
    $insert="[img][]" .$newname. "[][/img]";
} else {
    $width = "320";
    $t = "<span class=style2>Thumbnail image shown above</span><p></p>";
    $insert="[img][]" .$newname. "" "width=" .$width. "[][/img]";
}

echo "<img src=themes/default/images/check.png border=0 align=absmiddle>";

    echo "File Uploaded<br><br>(1) Copy<br><br>Hold the mouse button down and drag along the ENTIRE new image address, shown just below. It's called "selecting". Then press Ctrl-C keys to copy the new address:<br><br>";
echo "<table><tr><td bgcolor=f8f8f8><span class=style3>" . $insert . "</span></td></tr></table>";
echo "<br><br>(2) Paste:<br>Back on the Chat page, click to type in the box, and paste the link by using the Ctrl-V keys<p><br>";

echo "<img src=" .$newname. " width=" .$width. "><br>";
echo $t;
echo "<br><br>";
echo "<a href="javascript:NoConfirm()" style class="style2"><img src=themes/default/images/tab_remove.gif align=absmiddle border=0>  Close this window</a> </p>";
exit;

 }
    ?>
</p>

<img src="img/icones/emopicture.png" width="30" height="30" border="0"><br>
<p class="style1"><b>Upload and share an image in Chat</b> <br>
    <br>
    This can be any JPG, PNG or GIF image on your PC,<!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
    <br>
    provided it's no greater than 300Kb </p>
<span class="style1">
<form name="newad" method="post" enctype="multipart/form-data"  action="">
  <table>
    <tr><td class="style1"><input type="file" name="image"></td></tr>
    <tr><td class="style1"><input name="Submit" type="submit" value="Upload image"></td></tr>
  </table>
</form>
</span>