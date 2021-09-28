<?php
namespace Deployer;

host('deployer.org');

task('hello', function () {
    $output = run('ls -1');
    $lines = substr_count($output, "\n");
    writeln("Total files: $lines");
});