<?php $pageTitle = 'To Do' ; 

include ('includes/headerV2.php') ;

?>
<h1>To-Do List</h1>
<p>Shot Logger is still in early stages of development. Much remains to do.</p>
<ol>
  <li>Update admin section to use new statistics generator</li>
  <li>Update downloadable files to use new stats table.</li>
  <li>Add system to attach scale to a shot.</li>
  <li>Add median stats (and others?) to index.php</li>
  <li>Process filenames to excerpt timecode after they're imported. Then put the timecode in the frame's description (or summary). Can this be automated?</li>
  <li>Add field for alternative title (as in US title of foreign film). Make it searchable.</li>
  <li>Create system to delete bad frames/data from SL.</li>
  <li>Fix keywords.</li>
  <li>Add more charts, using Google.</li>
  <li><s>Check to make sure the SL directory has not been previously imported. But what to do if it has?</s></li>
  <li><s>CSS: separate data tables from other tables.
    </s>
    <ol>
      <li><s>E.g., Main admin page should not have the rollover effect that data tables use.</s></li>
    </ol>
  </li>
  <li><s>Calculate cumulative data for Shot Logger &amp; chart it automatically:
    </s>
    <ol>
      <li><s># of shots logged</s></li>
      <li><s>ASL of all shots</s></li>
    </ol>
  </li>
  <li><s>Create administrative system for entering data.</s></li>
  <li><s>Export album data as Excel spreadsheet.</s></li>
  <li><s>Add shot number (not Shot ID) to ShotListV2.php.</s></li>
  <li><s>Blend Shot Logger 1 images/data with Shot Logger 2.</s></li>
  <li><s>Change Shot Logger 1 graphics to indicate difference from Shot Logger 2.</s></li>
  <li><s>Fix &quot;date submitted&quot; in TitleListDetailV2.php -- when there is none.</s></li>
  <li><s>Insert shot number if one doesn't already exist -- e.g., for SL title #2.</s></li>
</ol>

  <?php 
include ('includes/footerV2.php'); // Include the footer
?>
