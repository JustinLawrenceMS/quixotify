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
        print_r($databasePath);
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
                $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id LIMIT :limit';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $startingText['id'], 'limit' => ceil($amount / $startingText['text_length']) + 1]);
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $text = substr(implode(' ', $texts), 0, $amount);
                break;
            case 'words':
                $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id LIMIT :limit';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $startingText['id'], 'limit' => ceil($amount / $startingText['word_count']) + 1]);
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $text = implode(' ', explode(' ', implode(' ', $texts), $amount + 1));
                break;
            case 'sentences':
                $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id LIMIT :limit';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $startingText['id'], 'limit' => $amount]);
                $texts = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $text = implode(' ', $texts);
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
