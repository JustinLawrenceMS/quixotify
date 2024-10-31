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

    private function neatenInput($text)
    {
        // @TODO sanitize data in DB
//        $text = trim($text); // Remove leading/trailing whitespace
//        $text = preg_replace('/\s+/', ' ', $text); // Replace multiple spaces with single space
//        $text = preg_replace('/” “/', '“', $text);
        return $text;
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

        var_dump('amount: ' . $amount);
        switch ($type) {
            case 'characters':
                $id = $startingText['id'];
                $limit = ceil($amount / 75 );
                $sql = "SELECT text FROM don_quixote_texts WHERE id >= $id LIMIT $limit";
                $stmt = $this->pdo->query($sql);
                $stmt->execute();
                $fetchedText = implode('', array_map('trim', $stmt->fetchAll(PDO::FETCH_COLUMN)));
                $text = mb_substr($fetchedText, 0, $amount, 'UTF-8');
                var_dump("Requested in Controller: $amount, Generated in Controller: " . mb_strlen($text, 'UTF-8'));
                break;
            case 'words':
                $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id LIMIT :limit';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $startingText['id'], 'limit' => ceil($amount / $startingText['word_count']) + 1]);
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $words = explode(' ', implode(' ', explode(' ', implode(' ', $texts), $amount)));
                $words = array_slice($words, 0, $amount);
                $text = implode(' ', $words);
                break;
            case 'sentences':
                $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id LIMIT :limit';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $startingText['id'], 'limit' => $amount]);
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $text = implode(' ', $texts);
                break;
        }

        return $this->neatenInput($text);
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
