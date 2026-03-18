<?php
$dirs = [
    __DIR__.'/resources/views/*/*.blade.php',
    __DIR__.'/resources/views/*.blade.php',
    __DIR__.'/app/Http/Controllers/*.php',
    __DIR__.'/app/Http/Middleware/*.php'
];
foreach($dirs as $g) {
    foreach(glob($g) as $f) {
        $c = file_get_contents($f);
        $original = $c;
        
        $c = str_replace(
            ['isHead()', 'isAdmin()', "in_array(\$role, ['kepala','head'])", "['kepala','head']"],
            ['isKepala()', 'isStaff()', "in_array(\$role, ['kepala', 'head'])", "['kepala', 'head']"], // keep original if unsure, wait no, let's just do isHead and isAdmin
            $c
        );
        $c = str_replace('isHead()', 'isKepala()', $c);
        $c = str_replace('isAdmin()', 'isStaff()', $c);
        $c = str_replace("in_array(\$role, ['kepala','head'])", "(\$role === 'kepala')", $c);
        
        if ($c !== $original) {
            file_put_contents($f, $c);
            echo "Updated: $f\n";
        }
    }
}
echo "Replacement success.\n";
