<?php 
  
  function find_recursive_dirs($path) {
      try {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path),
                                                RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($iterator as $path) {
          if ($path->isDir()) {
            if(substr($path->__toString(), (strrpos($path->__toString(), "/")+1)) != "." && substr($path->__toString(), (strrpos($path->__toString(), "/")+1)) != ".."){
              $directories[] = $path->__toString();
            }
          } 
        }
        return $directories;
      } catch (Exception $e) {
        echo "/* There was a problem, error: " . $e . " */";
      }
      
  }
  function find_all_files($directories) {
    foreach($directories as $directory){
      $childrenIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory . "/"), RecursiveIteratorIterator::CHILD_FIRST);
      foreach ($childrenIterator as $child) {
        if(substr($child->__toString(), (strrpos($child->__toString(), "/")+1)) != "." && substr($child->__toString(), (strrpos($child->__toString(), "/")+1)) != ".."){
          $files[] = $child->__toString();
        }
      }
    }
    return $files;
  }
  
  $path = "../administrator/panel/gallery/public/";
  $directories = find_recursive_dirs($path);
  $files = find_all_files($directories);
?>