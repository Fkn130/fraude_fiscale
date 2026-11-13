<?php

class Logger
{
    private static function write(string $level, string $message): void
    {
        $nom = date('Y-m-d') . "fraude.log";
        $date = date('Y-m-d H:i:s');    // création de la date (i = minute)
        $line = "[$date][$level] $message" . PHP_EOL;   

        // __DIR__ pointe toujours vers le dossier contenant CE fichier (donc le dossier "log")
        $cheminFichier = __DIR__ . '/' . $nom;

        file_put_contents($cheminFichier, $line, FILE_APPEND | LOCK_EX);
    }

    public static function info(string $message): void
    {
        self::write('INFO', $message);
    }

    public static function warning(string $message): void
    {
        self::write('WARNING', $message);
    }

    public static function error(string $message): void
    {
        self::write('ERROR', $message);
    }

    // Récupérer toutes les logs
    public static function getAll(): array
    {
        // On recrée le chemin exact du fichier d'aujourd'hui
        $cheminFichier = __DIR__ . '/' . date('Y-m-d') . "fraude.log";

        if (!file_exists($cheminFichier)) {
            return [];
        }

        return file($cheminFichier, FILE_IGNORE_NEW_LINES);
    }
}
?>