<?php

/**
 * Test: Nette\Latte\Engine and FormMacros: {formContainer}
 */

use Nette\Latte,
	Nette\Templating\FileTemplate,
	Nette\Forms\Form,
	Tester\Assert;


require __DIR__ . '/../bootstrap.php';


$form = new Form;
$form->addText('input1', 'Input 1');

$cont1 = $form->addContainer('cont1');
$cont1->addText('input2', 'Input 2');
$cont1->addText('input3', 'Input 3');

$cont2 = $cont1->addContainer('cont2');
$cont2->addCheckbox('input4', 'Input 4');
$cont2->addCheckbox('input5', 'Input 5');
$cont2->addCheckbox('input6', 'Input 6');

$cont1->addText('input7', 'Input 7');

$contItems = $form->addContainer('items');
$items = array(1, 3);
foreach ($items as $item) {
	$contItem = $contItems->addContainer($item);
	$contItem->addText('input', 'Input');
}

$form->addSubmit('input8', 'Input 8');


$template = new FileTemplate(__DIR__ . '/templates/forms.formContainer.latte');
$template->registerFilter(new Latte\Engine);
$template->_control = array('myForm' => $form);


$path = __DIR__ . '/expected/' . basename(__FILE__, '.phpt');
Assert::matchFile("$path.phtml", $template->compile());
Assert::matchFile("$path.html", $template->__toString(TRUE));
