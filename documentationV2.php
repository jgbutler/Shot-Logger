<?php 
/*
    Shot Logger facilitates the analysis of visual style in film and television 
	through screen shots and editing statistics.
    Copyright (C) 2007-2020 Jeremy Butler.
	Telecommunication and Film Department, The University of Alabama.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

$pageTitle = 'Documentation' ; 
include ('includes/headerA2.php') ;
?>
<h1>Documentation</h1>
<p>Shot Logger logs shots from DVDs and other digital video sources. It stores a frame capture from each and every shot in the video <em>and</em> it records each shot's starting time code (its hour, minute and second) in the name of the file. Shot Logger then processes that time code to determine the length of individual shots, as well as calculating several statistics for those lengths &#8212; including average shot length and standard deviation.</p>
<p>Shot Logger is intended for film and television students/scholars who wish to analyze visual style in detail, and who might want to do some basic statistical analysis of editing. In the latter regard, it was inspired by <a href="http://www.cinemetrics.lv/" target="_blank">CineMetrics</a>. What Shot Logger adds to CineMetrics is the ability to attach images, frame captures, to the statistical data.</p>
<p>Shot Logger relies on an open-source application: <a href="http://www.videolan.org/vlc/" target="_blank">Videolan VLC media player</a>. The VLC media player facilitates the capturing of frames and the recording of time code. (Version 0.1 of Shot Logger also drew on <a href="http://gallery.menalto.com/" target="_blank">Gallery</a>, a web-based photo album organizer, to handle the uploading and organization of images.) </p>
<h2>User Information</h2>
<ol>
  <li>Use the free <a href="http://www.videolan.org/vlc/">Videolan VLC media player</a> to capture images, one from the start of each shot.
    <ul>
      <li><a href="VLCandShotLogger/" target="_blank">A specific, step-by-step video tutorial is available here</a>.</li>
      <li><a href="http://www.tvcrit.com/tvcrit3/framegrab/VLC9/" target="_blank">Slightly out-of-date text instructions are here.</a></li>
    </ul>
  </li>
</ol>
<br>
<h2>Administrative Information</h2>
<h3>Labeling scheme for SL Upload Directories</h3>
<h4>Upper-level Directory (a film title or a television program title)</h4>
<ol>
  <li>Film or program title in lowercase (articles last).</li>
  <li>No spaces.</li>
</ol>
<br>
<h4>Lower, Episode-level Directory (TV only; not needed for film titles)</h4>
<ol>
  <li>Episode's original air date, if known
          (date format: YYYYMMDD).
    <ul>
      <li>If no air date, then episode season+number, with no space.
        <ul>
          <li>E.g., 0205 </li>
        </ul>
      </li>
    </ul>
  </li>
  <li>Follow episode date with episode title, if known, with no spaces or punctuation (i.e., no apostrophes, exclamation points, question marks, etc.)
    <ul>
      <li>E.g., 19740924WhosSorryNow (and <em>not</em> 19740924Who'sSorryNow?)</li></ul></li>
</ol>
<br>
<h4>Individual Frame Captures</h4>
<ol>
  <li>Smush the following together, with no spaces or punctuation:
    <ol>
      <li>Program/film name: shortened version of the name, with no articles </li>
      <li>If a TV episode, episode's original air date, if known
        (date format: YYYYMMDD).</li>
      <li>Time code, bracketed by &quot;qq&quot; (<a href="VLCandShotLogger/" target="_blank">see Tutorial for more information</a>)</li>
      <li>Optional: sequential number of the image's capture--as in the boldfaced number below
        <ul>
          <li>E.g., HappyDays19740924qq00_01_41qq<strong>00005</strong>.jpg</li></ul></li>
    </ol>
  </li>
</ol>
<br>
<h3>Upload Images to the SL Gallery</h3>
<ol>
  <li>If you created PNG files, you must convert them to JPEG (which is a much smaller file)</li>
  <li>In the Shot Logger <em>images</em> directory--if this is a theatrical film or the first episode of a TV program to be uploaded--create an upper-level directory for it.</li>
  <li>If this is a TV program, create an episode-level directory for the images.</li>
  <li>Use an FTP client, <a href="http://filezilla-project.org/" target="_blank">such as the free FileZilla</a>, to upload the images.</li>
</ol>
<br>
<h3>How to  Process Images</h3>
<ol>
  <li>Go to the Shot Logger Administration page.</li>
  <li>Select <em>View listing of uploaded files</em> to choose a directory for either a TV episode or a theatrical film. A list of all items' directories will display.</li>
  <li>Drill down to the specific directory you want to import. (It may help to sort the directories by <em>Last Modified</em>, in reverse chronological order.) Once you're inside that directory, click the <em>Yes, import data NOW</em> button. The <em>Item Data</em> form will appear.</li>
  <li>In the <em>Item Data</em> form, provide the data to be attached to the Shot Logger title for these items.
    <ol>
      <li>Provide the title <em>as it appears on the IMDb</em>. Titles can vary across countries and releases. Use the IMDb title to standardize the title.</li>
      <li>Quotation marks should not be used in any titles.</li>
      <li>The <strong>Internet Movie Database ID</strong> can be found by looking up the title and then examining the URL for the TV program or film. Titles start with the letters, &quot;tt&quot;. For example:<br />
        <em>http://www.imdb.com/title/tt0044230/</em>. With TV shows, be certain to get the IMDb ID for the entire show and not just a single expisode.<br />
        In this URL, the IMDb ID is <strong>tt0044230</strong>.</li>
      <li>Dates for TV episodes must be in this format: YYYY-MM-DD. E.g., 1957-10-04 for 4 October 1957. Dates for movies must be the release year &#8212; e.g., 2007.</li>
      <li>Click <em>Insert Data Now</em> to begin the import process. This will take you to the <em>Import Results</em> page.</li>
    </ol>
  </li>
  <li>On the <em>Import Results</em> page, you'll see a list of all the filenames, their timecodes, and their shot lengths. <strong>But you're not quite finished</strong>. Although the frame captures have been imported, Shot Logger has not yet done the statistical analysis of them. On the <em>Import Results</em> page, click &quot;skip ahead to this form&quot; or manually scroll to the bottom and check the <em>Data for SL Title</em> form. If everything appears correct, click the <em>Update record</em> button.</li>
  <li><strong>Now you are done!</strong></li>
</ol>

<?php 
include ('includes/footerV2.php'); // Include the footer
?>
