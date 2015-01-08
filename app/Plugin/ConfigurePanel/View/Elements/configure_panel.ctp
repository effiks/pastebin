<h2> <?php __d('settings', 'Configure Settings'); ?></h2>
<?php
    $headers = [
    __d('settings', 'key', true),
    __d('settings', 'type', true),
    __d('settings', 'value', true),
    ];
    $rows = [];

   echo '<h3>' . __d('settings', 'Neat Array', true) . '</h3>';
   echo $this->Toolbar->makeNeatArray($content);

   echo '<h3>' . __d('settings', 'Summary', true) . '</h3>';
   foreach ($content as $key => $value) {
       if (!is_array($value)) {
           $rows['General'][] = [$key, gettype($value), $value];
           continue;
       }
       foreach ($value as $k => $v) {
           if (is_object($v) || is_array($v)) continue;
           $rows[$key][] = [$k, gettype($v), $v];
       }
   }

   foreach ($rows as $title => $row) {
       echo "<h4>{$title}</h4>";
       echo $this->Toolbar->table($row, $headers, ['title' => $title]);
   }
?>