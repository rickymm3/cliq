<?php echo $head ?>
<body>
    <div class='wrapper'>
        <div class='top'>
            <?php echo $choose_cliq ?>
        </div>
        <?php echo $create_thread ?>
        <?php echo $view_threads ?>
          <script>
          $(function() {
            $( "#accordion" ).accordion();
          });
          </script>

        <div id="accordion">
        <?php echo $search_cliqs ?>
        </div>
    </div>
</body>
<?php echo $footer?>