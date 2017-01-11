# Index
```HTML
<?php
  $number = $result->num_rows;
  if ($number == 0){
    echo "Nothing here";
  } else {
?>
<?php
  while ($list = mysqli_fetch_array($result)) {
?>
  <div class="work col-md-4">
      <label>
          <div class="work-title">
              <h3><?php echo $list['TITLE']; ?></h3>
          </div>
          <div class="work-text">
            <?php echo $list['ABSTRACT']; ?>
          </div>
          <a class="detiles" role="button">More...</a>
          <a class="btn" href="http://www.youtube.com/watch?v=caF6nJxTejc" role="button">Video</a>
          <input type="CHECKBOX" name="lang4" class="checkbox" value="2">
          投我一票
      </label>
  </div>
  <?php }
}?>
```
# voteSystem
```html
<?php

  $resultNow = mysqli_query($connect, "SELECT * FROM `event` WHERE CURDATE() BETWEEN `VOTE_TIME_START` AND `VOTE_TIME_END` ORDER BY `YEAR` DESC");
  $resultOutDate = mysqli_query($connect, "SELECT * FROM `event` WHERE NOT CURDATE() BETWEEN `VOTE_TIME_START` AND `VOTE_TIME_END` ORDER BY `YEAR` DESC");

  if (($resultNow->num_rows + $resultOutDate->num_rows) != 0) {
    $result = $resultNow;
    while ($row = $result->fetch_array()) {
      $event_id = $row["E_ID"];
      $year = $row["YEAR"];
      $uptime_s = $row["UP_TIME_START"];
      $uptime_e = $row["UP_TIME_END"];
      $votetime_s = $row["VOTE_TIME_START"];
      $votetime_e = $row["VOTE_TIME_END"];
      $description = $row["E_DESC"];
      $limit = $row["E_LIMIT"];

      $vote_inform = mysqli_query($connect, "SELECT `E_ID`, SUM(`T_VOTE`) AS Teacher, SUM(`S_VOTE`) AS Student FROM `ticket` where `E_ID`=$event_id;")->fetch_array();
      $ticketStu = $vote_inform["Student"];
      $ticketTea = $vote_inform["Teacher"];

?>


<tr>
  <td> <input type="text" value="<?php echo $year; ?>" required="required" size="2"/></td>
  <td> <input type="date" value="<?php echo $uptime_s; ?>" required="required" size="5"/></td>
  <td> <input type="date" value="<?php echo $uptime_e; ?>" required="required" size="18"/></td>
  <td> <input type="date" value="<?php echo $votetime_s; ?>" required="required" size="18"/></td>
  <td> <input type="date" value="<?php echo $votetime_e; ?>" required="required" size="2"/></td>
  <td> <input type="text" value="<?php echo $limit; ?>" required="required" size="2"/></td>
  <td><?php echo $ticketStu . " || ". $ticketTea; ?></td>
  <td>
    <button type="button" class="btn btn-primary">修改</button>
    <button type="button" class="btn btn-danger">結束</button>
    <button type="button" class="btn btn-danger">刪除</button>
  </td>
</tr>


<?php
    }
    $result = $resultOutDate;
    while ($row = $result->fetch_array()) {
      $event_id = $row["E_ID"];
      $year = $row["YEAR"];
      $uptime_s = $row["UP_TIME_START"];
      $uptime_e = $row["UP_TIME_END"];
      $votetime_s = $row["VOTE_TIME_START"];
      $votetime_e = $row["VOTE_TIME_END"];
      $description = $row["E_DESC"];
      $limit = $row["E_LIMIT"];

      $vote_inform = mysqli_query($connect, "SELECT `E_ID`, SUM(`T_VOTE`) AS Teacher, SUM(`S_VOTE`) AS Student FROM `ticket` where `E_ID`=$event_id;")->fetch_array();
      $ticketStu = $vote_inform["Student"];
      $ticketTea = $vote_inform["Teacher"];

?>


<tr>
  <td><?php echo $year; ?></td>
  <td><?php echo $uptime_s; ?></td>
  <td><?php echo $uptime_e; ?></td>
  <td><?php echo $votetime_s; ?></td>
  <td><?php echo $votetime_e; ?></td>
  <td><?php echo $limit; ?></td>
  <td><?php echo $ticketStu . " || ". $ticketTea; ?></td>
  <td>
    <button type="button" class="btn btn-danger">刪除</button>
  </td>
</tr>


<?php
    }
  } else {
    echo "<tr>目前無投票</tr>";
  }
?>
```
