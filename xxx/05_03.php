<?php

declare(strict_types=1);

namespace demo0503;
// docker run --rm -v ${PWD}:/app --workdir=/app php:7.2-cli php xxx/05_03.php

chdir(dirname(__DIR__).'/manager');
require 'vendor/autoload.php';
################################################
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;

$translator = new Translator('ru');
$translator->addLoader('xlf', new XliffFileLoader());
$translator->addResource('xlf', 'vendor/symfony/validator/Resources/translations/validators.ru.xlf', 'ru', 'validators');

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
AnnotationRegistry::registerLoader('class_exists');

$validator = Validation::createValidatorBuilder()
	->enableAnnotationMapping()
	->setTranslator($translator)
	->setTranslationDomain('validators')
	->getValidator();
###############################################
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
	/**
	 * @var string
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	public $email;
	/**
	 * @var string
	 * @Assert\NotBlank()
	 * @Assert\Length(min=6)
	 */
	public $password;
}
################################################
$command = new Command();
$command -> email = 'wro';
$command -> password = 'sh';

/**
 * @var ConstraintViolationListInterface|ConstraintViolationInterface[] $violations
 */
$violations = $validator->validate($command);

if ($violations->count()){
	foreach($violations as $violation){
		echo $violation->getPropertyPath() . ': ' . $violation->getMessage() . PHP_EOL;
	}

} else {
	echo 'Command is valid.' . PHP_EOL;
}
########################################

