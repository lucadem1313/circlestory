<?php
$relative = '../';
include($relative."includes/define.php");
include($relative."includes/connect.php");
include($relative."includes/login.php");


$pagetitle = "New Story";

if(!$loggedin)
{
    header("Location: ".$relative);
}
?>


<!DOCTYPE html>

<html>
<head>
    <title><?php echo $pagetitle; ?> | <?php echo $sitename; ?></title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <?php include($relative."includes/head.php"); ?>
    <script>
        $(document).ready(function(){
            $('#editor').trumbowyg({
                fullscreenable: false,
                closable: false,
                btns: ['formatting', '|', 'underline', 'bold', 'italic']
            });
            $("#addsubmission").submit(function(e){
                e.preventDefault();
                
                //$("#story").append("<p class='prewritten story continued'><strong>Edit By:&nbsp;&nbsp; <a href='<?php echo $pathtouser.'ltdemian'; ?>'>Luca Demian</a> - 4/3/16 1:34pm</strong><br>"+$("#editor").html().replace(/<div>/g, '<br>').replace(/<\/div>/g, '')+"</p>");
                $.ajax({
                    type: "POST",
                    url: "process.php",
                    data: {post: $("#editor").html().replace(/<div>/g, '<br>').replace(/<\/div>/g, ''), genre: $("select[name='genre']").val(), tags: $('input[name="tags"]').val(), title: $('input[name="title"]').val()},
                    success: function(response){
                        window.location.reload();
                    }
                });
            });
            
            
            
        });
    </script>
</head>

<body>

<?php include($relative."includes/header.php");?>
<div id="container">
    
    <br><br><br>
    <form id="addsubmission" method="post">
        <input type="text" name="title" placeholder="Story title" autocomplete="off"><br><br>
        <div id="editor" placeholder="New Story..."></div><br>
        <input type="text" name="tags" placeholder="Tag One, Tag Two, Etc..." autocomplete="off"><br>
        <select name="genre">
            <?php
                $selectsubjects = mysql_query("SELECT * FROM subjects");
                while($row = mysql_fetch_array($selectsubjects))
                {
                    echo '<option value="'.$row{'id'}.'">'.$row{'name'}.'</option>';
                }
            ?>
        </select>
        <button class="submit-button" id='save' type="submit">Save</button>
    </form>
</div>
<div id="overlay"><br><br><br><br>
    <form id="reportform" class='overlayform' action="post">
        <input type="text" name="title" placeholder="Report title..."><br><br>
        <textarea name='text'></textarea><br>
        <div class='buttons'><button class='simple-button'>Report</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type='button' class='simple-button'>Cancel</button></div>
    </form>
</div>
<?php include($relative."includes/footer.php"); ?>
</body>
</html>
