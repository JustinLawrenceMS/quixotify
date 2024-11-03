<?php

namespace Quixotify;

use PDO;
use PDOException;

class Controller
{
    private $pdo;

    public function __construct()
    {
        $databasePath = __DIR__ . '/database.db';
        $this->pdo = new PDO('sqlite:' . $databasePath);
    }


    private function validateInput($amount, $type)
    {
        if (!in_array($type, ['characters', 'words', 'sentences'])) {
            throw new Exception('Invalid type');
        }

        if (!is_int($amount) || $amount <= 0) {
            throw new Exception('Invalid amount');
        }
    }

    private function getStartingText()
    {
        $sql = 'SELECT * FROM don_quixote_texts ORDER BY RANDOM() LIMIT 1';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function generateIpsumText($type, $amount)
    {
        $startingText = $this->getStartingText();

        switch ($type) {
            case 'characters':
                $id = $startingText['id'];
                $limit = ceil($amount / 75 );
                $sql = "SELECT text FROM don_quixote_texts WHERE id >= $id LIMIT $limit";
                $stmt = $this->pdo->query($sql);
                $stmt->execute();
                $fetchedText = implode(' ', array_map('trim', $stmt->fetchAll(PDO::FETCH_COLUMN)));
                $text = mb_substr($fetchedText, 0, $amount, 'UTF-8');
                $text = mb_substr($text, 0, -3, 'UTF-8') . '...';
                break;
            case 'words':
                $limit = ceil($amount / $startingText['word_count']) + 10;
                $sql = "SELECT text FROM don_quixote_texts WHERE id >= {$startingText['id']} LIMIT $limit";
                $stmt = $this->pdo->query($sql);
                $stmt->execute();
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $words = explode(' ', implode(' ', explode(' ', implode(' ', $texts), $amount)));
                $words = array_slice($words, 0, $amount);
                $text = implode(' ', $words);
                $text = trim($text);
                break;
            case 'sentences':
                $limit = (int) $amount;
                $sql = "SELECT text FROM don_quixote_texts WHERE id >= {$startingText['id']} LIMIT $limit";
                $stmt = $this->pdo->query($sql);
                $stmt->execute();
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $text = implode(' ', $texts);
                $text = trim($text);
                break;
        }

        return $text;
    }

    public function generateByCharacters($characters)
    {
        $this->validateInput($characters, 'characters');
        return $this->generateIpsumText('characters', $characters);
    }

    public function generateByWords($words)
    {
        $this->validateInput($words, 'words');
        return $this->generateIpsumText('words', $words);
    }

    public function generateBySentences($sentences)
    {
        $this->validateInput($sentences, 'sentences');
        return $this->generateIpsumText('sentences', $sentences);
    }
}
