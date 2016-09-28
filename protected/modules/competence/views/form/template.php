<?php
/**
 * @var \competence\models\Question $question
 * @var \competence\models\Test $test
 */
echo '<?php'."\r\n";
?>
namespace competence\models\test\<?=$test->Code?>;

class <?=$question->Code?> extends \<?=trim($question->Type->Class, '\\')?><?=' '?>
{

}
