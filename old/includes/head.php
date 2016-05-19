<link rel="stylesheet" type="text/css" href="<?php echo $relative.'includes/header.css'; ?>">
<link rel="stylesheet" type="text/css" href="<?php echo $relative.'includes/footer.css'; ?>">

<script src="//code.jquery.com/jquery-latest.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/1.1.7/trumbowyg.min.js"></script>

<link href="<?php echo $relative."css/trumbowyg.css"; ?>" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/1.1.7/ui/images/icons.png">
<link href='https://fonts.googleapis.com/css?family=Slabo+27px' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>

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
    });
</script>