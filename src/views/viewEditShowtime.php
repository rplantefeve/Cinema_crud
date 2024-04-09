<?php $this->title = "Gestion des cinémas - Ajouter une séance"; ?>
<header>
    <h1>Séances du cinéma <?= $cinema['DENOMINATION'] ?></h1>
    <h2>Pour le film <?= $film['TITRE'] ?></h2>
</header>
<form method="post">
    <fieldset>
        <label for="datedebut">Date de début : </label>
        <input id="datedebut" type="date" name="datedebut" placeholder="jj/mm/aaaa" value="<?= $seance['dateDebut'] ?>">
        <label for="heuredebut">Heure de début : </label>
        <input type="time" name="heuredebut" placeholder="hh:mm" value="<?= $seance['heureDebut'] ?>">

        <label for="datefin">Date de fin : </label>
        <input type="date" name="datefin" placeholder="jj/mm/aaaa" value="<?= $seance['dateFin'] ?>">
        <label for="heurefin">Heure de fin : </label>
        <input type="time" name="heurefin" placeholder="hh:mm" value="<?= $seance['heureFin'] ?>">
        <!-- les anciennes date et heure début et fin -->
        <input type="hidden" name="dateheurefinOld" value="<?= $seance['dateheureFinOld'] ?>">
        <input type="hidden" name="dateheuredebutOld" value="<?= $seance['dateheureDebutOld'] ?>">
        <label for="version">Version : </label>
        <select name="version">
            <option value="VO" <?php
            if ($seance['version'] == 'VO'): echo "selected";
            endif;
            ?>>VO</option>
            <option value="VF" <?php
            if ($seance['version'] == 'VF'): echo "selected";
            endif;
            ?>>VF</option>
            <option value="VOSTFR" <?php
            if ($seance['version'] == 'VOSTFR'): echo "selected";
            endif;
            ?>>VOSTFR</option>
        </select>
        <input type="hidden" value="<?= $from ?>" name="from">
    </fieldset>
    <input type="hidden" name="cinemaID" value="<?= $cinema['CINEMAID'] ?>">
    <input type="hidden" name="filmID" value="<?= $film['FILMID'] ?>">
    <?php
// si c'est une modification, c'est une information dont nous avons besoin
    if (!$isItACreation) {
        ?>
        <input type="hidden" name="modificationInProgress" value="true"/>
        <?php
    }
    ?>
    <button type="submit">Sauvegarder</button>
</form>
<?php if ($fromCinema): ?>
    <form action="index.php">
        <input name="action" type="hidden" value="cinemaShowtimes" />
        <input name="cinemaID" type="hidden" value="<?= $cinema['CINEMAID'] ?>">
        <button type="submit">Retour aux séances du cinéma</button>
    </form>
<?php else: ?>
    <form action="index.php">
        <input name="action" type="hidden" value="movieShowtimes" />
        <input name="filmID" type="hidden" value="<?= $film['FILMID'] ?>">
        <button type="submit">Retour aux séances du film</button>
    </form>
<?php endif; ?>
