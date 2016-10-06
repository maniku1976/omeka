<?php
/* Load scripts */
queue_js_file('jquery-1.12.4.min');
queue_js_file('jquery-ui');
queue_js_file('jquery.mousewheel.min');
queue_js_file('comments');
queue_js_file('page-formatting-xhtml');
queue_js_file('toggles-xhtml');
queue_js_file('uv-image-viewer-xhtml');
queue_js_file('jquery-image-viewer-xhtml');

echo head(array('title' => metadata('item', array('Dublin Core', 'Title')),'bodyclass' => 'item show')); ?>

<h1 style="margin-bottom:1em;margin-top:1em;">
  <?php
  $date = date('j.n.Y', strtotime(metadata('item', array('Dublin Core', 'Date'))));
  echo metadata('item', array('Dublin Core', 'Title')).", "
  .$date; ?>
  <!--<span style="float:right;">
    <?php
    // Link for the TEI file attached to each item
    $files = $item->Files;
    foreach ($files as $file):
      if ($file->getExtension() == 'xml'):
        echo '<a class="xmlBt" href="http://localhost/files/original/'.metadata($file,'filename').'">
        <span class="xml">XML</span></a>';
      endif;
    endforeach; ?>
  </span>-->
</h1>

<h2 style="font-weight:bold;">1. UV-plugin, PHP-käännetty XML-transkriptio</h2>
<div id="exhibit3">
  <div id="exhibit3a">
    <?php
    echo get_specific_plugin_hook_output('UniversalViewer', 'public_items_show', array(
      'view' => $this,
      'record' => $item,
    ));
    ?>
  </div>
  <div id="exhibit3b">
    <!-- Buttons for showing/hiding transcription markings and comments -->
    <span style="display:inline;float:left;">
      <input type="checkbox" onclick="toggleMarkingsXML()" checked/>Merkinnät&nbsp;&nbsp;
      <input type="checkbox" onclick="toggleCommentsXML()" checked/>Kommentit&nbsp;&nbsp;&nbsp;
      <!--<?php echo '<a style="color:#444444;border-bottom:none;" href="http://localhost/files/original/'
      .metadata($file,'filename').'">&#128190; Lataa TEI-tiedosto</a>';?>-->
      <?php echo '<a style="color:#444444;border-bottom:none;" href="'
      .metadata('item', array('Item Type Metadata', 'XML File')).'">&#128190; Lataa TEI-tiedosto</a>';?>
    </span>
    <!-- Buttons for moving back and forth in pictures and transcription-->
    <span style="float:right;">
      <a id="btPrevXML" style="cursor:pointer;font-size:20px;">&#8592;</a>
      <a id="btNextXML" style="cursor:pointer;font-size:20px;">&#8594;</a>
    </span>
    <!-- Frame for displaying transcription -->
    <div class="textFrame">
      <?php
      // Load TEI file attached to item, load XSL stylesheet, transform TEI to XHTML
      $files = $item->Files;
      foreach ($files as $file):
        if ($file->getExtension() == 'xml'):
          $xmlDoc = new DOMDocument();
          $xmlDoc->load("http://localhost/files/original/".metadata($file,'filename'));
          $xslDoc = new DOMDocument();
          $xslDoc->load("http://localhost/files/original/TEI-to-HTML.xsl");
          $proc = new XSLTProcessor();
          $proc->importStylesheet($xslDoc);
          echo $proc->transformToXML($xmlDoc);
        endif;
      endforeach;
      ?>
    </div>
  </div>
</div>

<h2 style="font-weight:bold;">2. Käsin rakennettu viewer (jquery + lisäosia) + PHP-käännetty XML-transkriptio</h2>
<div id="exhibit2">
  <div id="exhibit2a">
    <!-- Frame for displaying pictures -->
    <div id="picframe">
      <!-- Buttons for metadata menu, enter/exit fullscreen, reset image size -->
	     <span id="buttons">
            <a id="origSize" title="Alkuperäinen koko" style="cursor:pointer;font-size:22px;
            border-bottom:none;">&#8594;&#8592;&nbsp;&nbsp;</a>
            <a id="fullScreen" title="Koko sivun näkymä" style="cursor:pointer;font-size:22px;
            border-bottom:none;">&#x2921;&nbsp;&nbsp;</a>
            <a id="closeFull" title="Poistu" style="cursor:pointer;font-size:20px;
            border-bottom:none;display:none;">&#x2715;&nbsp;&nbsp;</a>
            <a id="metadata" title="Metadata" style="cursor: pointer;font-size:20px;border-bottom:none;">?</a>
      </span>
      <?php
      // Fetch images attached to each item
      $files = $item->Files;
      foreach ($files as $file):
        if ($file->getExtension() == 'jpg'):
          echo '<img class="pic" style="background:transparent" src="http://localhost/files/original/'.metadata
          ($file,'filename').'" />';
        endif;
      endforeach; ?>
    </div>
    <!-- Metadata panel; some Finnish metadata titles replaced -->
    <div id="infopanel">
      <?php
      $texts = all_element_texts('item');
      $texts = str_replace('Nimeke', 'Otsikko', $texts);
      $texts = str_replace('Aikamääre', 'Kirjoitusaika', $texts);
      echo $texts;
      ?>
    </div>
  </div>
  <div id="exhibit2b">
    <!-- Buttons for showing/hiding transcription markings and comments. -->
    <span id="span1">
      <input type="checkbox" onclick="toggleMarkingsHTML2()" checked/>Merkinnät&nbsp;&nbsp;
      <input type="checkbox" onclick="toggleCommentsHTML2()" checked/>Kommentit&nbsp;&nbsp;&nbsp;
      <?php echo '<a style="color:#444444;border-bottom:none;" href="http://localhost/files/original/'
      .metadata($file,'filename').'">&#128190; Lataa TEI-tiedosto</a>';?>
    </span>
    <!-- Buttons for moving back and forth in pictures/transcription -->
    <span id="span2">
      <a id="prevPic" style="cursor:pointer;font-size:20px;">&#8592;&nbsp;</a>
      <a id="nextPic" style="cursor:pointer;font-size:20px;">&#8594;</a>
    </span>
    <!-- Frame for displaying transcription -->
    <div class="textFrame">
      <?php
      // Load TEI file attached to item, load XSL stylesheet, transform TEI to XHTML
      $files = $item->Files;
      foreach ($files as $file):
        if ($file->getExtension() == 'xml'):
          $xmlDoc = new DOMDocument();
          $xmlDoc->load("http://localhost/files/original/".metadata($file,'filename'));
          $xslDoc = new DOMDocument();
          $xslDoc->load("http://localhost/files/original/TEI-to-HTML.xsl");
          $proc = new XSLTProcessor();
          $proc->importStylesheet($xslDoc);
          echo $proc->transformToXML($xmlDoc);
        endif;
      endforeach;
      ?>
    </div>
  </div>
</div>

<!-- The following prints a list of all tags associated with the item -->
<?php if (metadata('item', 'has tags')): ?>
  <div id="item-tags" class="element">
    <h3><?php echo __('Tags'); ?></h3>
    <div class="element-text"><?php echo tag_string('item'); ?></div>
  </div>
<?php endif;?>

<nav>
  <ul class="item-pagination navigation">
    <li id="previous-item" class="previous"><?php echo link_to_previous_item_show(); ?></li>
    <li id="next-item" class="next"><?php echo link_to_next_item_show(); ?></li>
  </ul>
</nav>

<?php echo foot(); ?>

<!-- The following prints a citation for this item. -->
<!--<div id="item-citation" class="element">
<h3><?php echo __('Citation'); ?></h3>
<div class="element-text"><?php echo metadata('item', 'citation', array('no_escape' => true)); ?></div>
</div>-->

<!-- If the item belongs to a collection, the following creates a link to that collection. -->
<!--<?php if (metadata('item', 'Collection Name')): ?>
<div id="collection" class="element">
<h3><?php echo __('Collection'); ?></h3>
<div class="element-text"><p><?php echo link_to_collection_for_item(); ?></p></div>
</div>
<?php endif; ?>-->
