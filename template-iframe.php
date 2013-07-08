<?php
  /*
  Template Name: Iframe Template
  */
  acf_form_head();
  get_header();
?>
      <style type="text/css">
        body, #page, #main{margin:0 !important; padding:0 !important; width:100%; height:100%;}
        #iframe-external{width:100%; height:100%;}
        #iframe-external-hide{position:fixed; right:0; bottom:0; font-size:14px; background:#333; color:#fff; padding:3px 5px;}
        #iframe-external-hide:hover{background:#c00;}
      </style>
      <script type="text/javascript">
        jQuery(window).resize(function(){
          jQuery("#main").height($(window).height()-jQuery("#main").offset().top)
        });
        jQuery("#iframe-external-hide").live('click', function(e){
          e.preventDefault();
          var header = jQuery("#branding"); if(header.is(':hidden')) header.show(); else header.hide();
          jQuery(window).resize();
          return false;
        });
        jQuery(window).resize();
      </script>

      <iframe id="iframe-external" src="<?php echo $post->post_content?>">
        Warning: Your browser does not support iframes
      </iframe>
      <a href="#" id="iframe-external-hide">Скрыть/показать элементы страницы</a>
    </div>
  </div>
  <?php wp_footer()?>
</body>
</html>