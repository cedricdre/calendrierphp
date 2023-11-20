<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectMonthAndYear = $_POST['selectMonthAndYear']; // date selectionné par USer
} else {
    $selectMonthAndYear = date('Y-m'); // date du jour
}

$day = new DateTime($selectMonthAndYear);

$day->modify("first day of this month");
$DayStart = $day->format('N'); // 1er jours du mois

$day->modify("last day of this month");
$DayEnd = $day->format('N'); // Dernier jour du mois

$RemainingDay = 7 - $DayEnd; // variable pour définir les jours restants (case vide)


$month = $day->format('m'); // Mois au format numérique
$year = $day->format('Y'); // Année 4 chiffre 
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); // Nombre de jour dans mon mois


// en francais
$formatter = new IntlDateFormatter('fr_FR');
$formatter->setPattern('MMMM');
$frenchDate = $formatter->format($day);

$dayofday = new DateTime();
$dayofdayDisplay = $dayofday->format('Y-n-j');

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <title>TP calendrier PHP</title>
</head>

<body>
    <header></header>

    <main class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Formulaire d'envoie de la date -->
                    <form method="post" data-bs-theme="dark">
                        <div class="row g-3 align-items-center justify-content-center">
                            <div class="col-auto">
                                <label for="selectMonthAndYear" class="col-form-label fs-5">Selectionner un mois :</label>
                            </div>
                            <div class="col-auto">
                                <input type="month" class="form-control" id="selectMonthAndYear" name="selectMonthAndYear" value="<?= $selectMonthAndYear ?>">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-outline-danger text-center">Je valide</button>
                            </div>
                        </div>
                    </form>
                    <!-- Affichage du mois et de l'année -->

                    <div class="row align-items-center mt-3">
                        <div class="col-lg-6">
                            <h2 class="display-2 text-center text-lg-start fw-bold text-capitalize"><?= $frenchDate ?></h2>
                        </div>
                        <div class="col-lg-6">
                            <h2 class="display-2 text-danger text-center text-lg-end abril-font"><?= $year ?></h2>
                        </div>
                    </div>
                    <!-- Affichage du calendrier -->
                    <div class="calendar">
                        <!-- Jours de la semaine -->
                        <div class="row">
                            <div class="col day fw-lighter">Lun</div>
                            <div class="col day fw-lighter">Mar</div>
                            <div class="col day fw-lighter">Mer</div>
                            <div class="col day fw-lighter">Jeu</div>
                            <div class="col day fw-lighter">Ven</div>
                            <div class="col day fw-lighter">Sam</div>
                            <div class="col day fw-lighter">Dim</div>
                        </div>

                        <div class="row row-cols-6">
                            <?php
                            for ($i = 1; $i < $DayStart; $i++) { ?>
                                <div class='col day day-off'></div>
                            <?php }
                            ?>

                            <?php
                            for ($dayInMonth = 1; $dayInMonth <= $daysInMonth; $dayInMonth++) {

                                $dayStyle = "$year-$month-$dayInMonth";
                                if ($dayofdayDisplay == $dayStyle) {                         
                                    $classRed = 'text-danger border-botom border-danger';
                                }
                            ?>
                                <div class='col day <?= $classRed ?>'><?= $dayInMonth ?></div>
                            <?php }
                            ?>

                            <?php
                            for ($i = 0; $i < $RemainingDay; $i++) { ?>
                                <div class='col day day-off'></div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>