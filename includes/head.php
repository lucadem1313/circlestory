

<script src="//code.jquery.com/jquery-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/1.1.7/trumbowyg.min.js"></script>

<link rel='icon' href='<?php echo $relative; ?>images/favicon.png'>

<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

<link href="<?php echo $relative."css/trumbowyg.css"; ?>" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/1.1.7/ui/images/icons.png">

<link rel="stylesheet" type="text/css" href="<?php echo $relative.'includes/header.css'; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $relative.'includes/footer.css'; ?>">

<title><?php echo $currentpage." | ".$sitename; ?></title>

<script>
    $(document).ready(function(){
        var height = $("#myaccountactionlist").height();
        $("#myaccountactionlist").css({"height": "0px", "opacity": "0"});
        $("#myaccountactionlist").css({"min-width": $("#myaccountlink").width() + "px"});
        $("#myaccountactionlist").css({"transition": "all 0.3s"});
        
        $("#myaccountlink").click(function(){
            if($("#myaccountactionlist").height() > 0)
            {
                $("#myaccountactionlist").css({"height": "0px", "opacity": "0"});
            }
            else if($("#myaccountactionlist").height() < height)
            {
                $("#myaccountactionlist").css({"height": height+"px", "opacity": "1"});
            }
        });
        
        $(document).click(function(){
            if($("#myaccountactionlist").height() > 0)
            {
                $("#myaccountactionlist").css({"height": "0px", "opacity": "0"});
            }
        });
        $('#uparrow').fadeOut(0);
        $(window).scroll(function(){
            if(window.scrollY > 400)
            {
                $('#uparrow').fadeIn(400);
            }
            else
            {
                $('#uparrow').fadeOut(400);
            }
        });
        $("#uparrow").click(function(){
            $('body').animate({ scrollTop: '0px'});
        });
    });
</script>