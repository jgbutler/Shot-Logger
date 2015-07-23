<?php $pageTitle = 'Download Source Code' ; 

include ('includes/headerV2.php') ;

?>

<h1>Download Data</h1>
<p>Shot Logger's data, although copyrighted, are available for download and use according to the  <a href="http://creativecommons.org/licenses/by-nc-sa/3.0/us/" target="_blank"><em>Creative Commons Attribution-Noncommercial-Share Alike 3.0 United States License</em></a>. The following files are suitable for importing into Excel or other spreadsheet/database applications.</p>
<ul>
  <li><a href="data/download/download_ShotLogger_TitleData.php">Shot Logger <em>titles</em> data</a>
    <ul>
      <li>File size: <?php
		$filename = 'data/download/ShotLogger_TitleData.txt';
		echo format_bytes (filesize($filename)) ;
		?>
    </li>
      <li>Last updated:
  		<?php 
		if (file_exists($filename)) {
    	echo date ("d F Y H:i:s", filemtime($filename));
		}
		?>.
      </li>
    <li>A tab-delimited file listing all Shot Logger titles with their statistics (e.g., ASL)</li>
      <li><a href="data/download/download_ShotLogger_TitleDataXML.php">Also availalble in XML format</a>
        <ul>
          <li>File size:
            <?php
		$filenameXML = 'data/download/ShotLogger_TitleData.xml';
		echo format_bytes (filesize($filenameXML)) . "."; 
		?>
        </li>
      <li>Last updated:
  		<?php 
		if (file_exists($filenameXML)) {
    	echo date ("d F Y H:i:s", filemtime($filename));
		}
		?>.
      </li>
        </ul>
</ul>
  </li>
  <li><a href="data/download/tcf-shotlogger.sql.gz"><em>All</em> Shot Logger data in five MySQL tables</a>
    <ul>
      <li>File size: <?php
		$filenameAllData = 'data/download/tcf-shotlogger.sql.gz';
		echo format_bytes (filesize($filenameAllData)) ;
		?>.</li>
      <li>Last updated:
        <?php 
		if (file_exists($filenameAllData)) {
    	echo date ("d F Y H:i:s", filemtime($filenameAllData));
		}
		?>
        . </li>
      <li>The data have been compressed into a single GZ file.</li>
    </ul>
  </li>
  <li><a href="data/download/download_tcf-shotlogger_Table_Structure_Only.php">Shot Logger MySQL tables</a> (empty; MySQL structure only)
<ul>
      <li>File size:
        <?php
		$filenameTables = 'data/download/tcf-shotlogger_Table_Structure_Only.sql.gz';
		echo format_bytes (filesize($filenameTables)) ;
		?>
        .</li>
      <li>Last updated:
        <?php 
		if (file_exists($filenameTables)) {
    	echo date ("d F Y H:i:s", filemtime($filenameTables));
		}
		?>
        . </li>
    </ul>
  </li>
</ul>
<h1>Download Source Code</h1>
<p>Shot Logger relies upon the open-source project, <a href="http://www.videolan.org/vlc/" target="_blank">Videolan VLC media player</a>. In keeping with the licensing of this project, Shot Logger's source code will also be made available as open source.</p>
<p>The current version is way too primitive for public release, but once it has been made presentable, it will be released here. We make no promises about a release date.</p>
<h1>Download VLC</h1>
<p><img src="VLCandShotLogger/GetVLC.png" width="298" height="122" alt="Get VLC Media Player" align="left" />Much as we love VLC, we have to acknowledge one occasional problem with it. Sometimes updates to VLC manage to break a key function that Shot Logger requires. At least twice during our use of VLC, the ability to embed time-code data into the names of &quot;screen shots&quot; has been busted. </p>
<p>As a safeguard against this problem, we provide (below) versions of VLC that <em>do</em> support time-code embedding.</p>
<p>Also, although VLC contains no malware, it will take over the playing of <em>all</em> of your audio and video files if you do not un-check certain boxes during installation. Specifically, VLC asks you to &quot;Choose Components&quot; during installation:</p>
<p><img src="VLCandShotLogger/VLC2.0.8Setup_01.jpg" width="513" height="399" alt="VLC set-up screen 1" /></p>
<p>If you do <em>not</em> want VLC to be your computer's default media-playing software, then scroll down in the display box until you see this:</p>
<p><img src="VLCandShotLogger/VLC2.0.8Setup_02.jpg" width="513" height="399" alt="VLC setup 2" /></p>
<p>See all those checked boxes under &quot;File Type Associations&quot;? Un-check them so that it looks like this:</p>
<p><img src="VLCandShotLogger/VLC2.0.8Setup_03.jpg" width="513" height="399" alt="VLC setup 3" /></p>
<p>Now, your standard audio and video player will continue to work as before.</p>
<h2>Download VLC</h2>
<p><img src="VLCandShotLogger/GetVLC.png" width="298" height="122" alt="Get VLC Media Player" align="left" />Right-click the name of your operating system below and then choose to &quot;Save Link as...&quot; or &quot;Save Target...&quot; or something similar. Save the file somewhere you can find later. Then run the file to install VLC.</p>
<ul>
  <li><a href="VLCandShotLogger/vlc-2.0.8-win32.exe">Windows (32-bit)</a> If you don't know what type of Windows you have, choose this one.</li>
  <li><a href="VLCandShotLogger/vlc-2.0.8-win64.exe">Windows (64-bit)</a></li>
  <li><a href="VLCandShotLogger/vlc-2.0.8.dmg">Mac OS</a></li>
</ul>
<p>If you'd like to download VLC from its home page, <a href="http://www.videolan.org/vlc/" target="_blank">head over here</a>.</p>
<?php 
include ('includes/footerV2.php') ;
?>
