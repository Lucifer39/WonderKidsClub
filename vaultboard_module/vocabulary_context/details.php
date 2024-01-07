<?php 
    $dir = __DIR__;
    $parentdir = dirname($dir);
    require_once($parentdir . "/global/navbar.php");

    $context_id = $_GET["context_id"] ?? 0;
?>

<script>
    var context_id = <?php echo json_encode($context_id); ?>;
</script>

<link rel="stylesheet" href="styles.css">

<div class="container">
    <a href="index.php"><button class="go-back-btn">Go back</button></a>
    <h1>Vocabulary Context</h1>
    <section class="container-content">
        <aside class="context-details-section" id="context-details-section"></aside>
        <main class="context-words-section">
            

<div id="carousel">

   <!-- <div class="hideLeft">
    <img src="https://i1.sndcdn.com/artworks-000165384395-rhrjdn-t500x500.jpg">
  </div> -->

  <!-- <div class="prevLeftSecond">
    <img src="https://i1.sndcdn.com/artworks-000185743981-tuesoj-t500x500.jpg">
  </div>

  <div class="prev">
    <img src="https://i1.sndcdn.com/artworks-000158708482-k160g1-t500x500.jpg">
  </div> -->

  <!-- <div class="selected">
    <img src="https://i1.sndcdn.com/artworks-000062423439-lf7ll2-t500x500.jpg">
  </div>

  <div class="next">
    <img src="https://i1.sndcdn.com/artworks-000028787381-1vad7y-t500x500.jpg">
  </div>

  <div class="nextRightSecond">
    <img src="https://i1.sndcdn.com/artworks-000108468163-dp0b6y-t500x500.jpg">
  </div>

  <div class="hideRight">
    <img src="https://i1.sndcdn.com/artworks-000064920701-xrez5z-t500x500.jpg">
  </div> -->

</div>

<div class="buttons">
  <button id="prev">Prev</button>
  <span id="nav-button-count"></span>
  <button id="next">Next</button>
</div>

        </main>
    </section>
</div>

<script src="scripts/context_details.js"></script>