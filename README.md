# FootballScoreBoard

The application was written in PHP 8.2, tests written using PHPUnit.

Example usage:

$scoreBoard = new FootballScoreBoard();

$scoreBoard->startGame("Mexico", "Canada");
$scoreBoard->startGame("Spain", "Brazil");
$scoreBoard->startGame("Germany", "France");
$scoreBoard->startGame("Uruguay", "Italy");
$scoreBoard->startGame("Argentina", "Australia");

$scoreBoard->updateScore("Mexico", "Canada", 0, 5);
$scoreBoard->updateScore("Spain", "Brazil", 10, 2);
$scoreBoard->updateScore("Germany", "France", 2, 2);
$scoreBoard->updateScore("Uruguay", "Italy", 6, 6);
$scoreBoard->updateScore("Argentina", "Australia", 3, 1);

$summary = $scoreBoard->getSummary();
foreach ($summary as $gameSummary) {
echo $gameSummary . PHP_EOL;
}