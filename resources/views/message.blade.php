<div>
    <p>
        <a href="#" onclick="showFullMessage()">Click here to see the full message</a>
    </p>
    <p id="fullMessage" style="display: none;">
        <?php
        $message = "Your dynamic message goes here";
        echo $message;
        ?>
    </p>
</div>

<script>
    function showFullMessage() {
        var fullMessage = document.getElementById("fullMessage");
        fullMessage.style.display = "block";
    }
</script>