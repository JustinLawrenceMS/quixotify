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
        $text = trim($text); // Remove leading/trailing whitespace
        $text = preg_replace('/\s+/', ' ', $text); // Replace multiple spaces with single space
        $text = preg_replace('/” “/', '“', $text);
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

        switch ($type) {
            case 'characters':
                $text = '';
                $remainingChars = $amount;
                $id = $startingText['id'];

                do {
                    $sql = 'SELECT text FROM don_quixote_texts WHERE id >= :id ORDER BY id ASC LIMIT 1';
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(['id' => $id]);

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row === false) break;

                    $id++; // Increment ID for the next query.
                    $textLength = strlen($row['text']);

                    if ($textLength <= $remainingChars) {
                        $text .= $row['text'];
                        $remainingChars -= $textLength;
                    } else {
                        $text .= substr($row['text'], 0, $remainingChars);
                        break;
                    }

                } while ($remainingChars > 0);

                break;
            case 'words':
                $texts = [];
                $remainingWords = $amount;
                $id = $startingText['id'];

                do {
                    $sql = 'SELECT text, word_count FROM don_quixote_texts WHERE id >= :id ORDER BY id ASC LIMIT 1';
                    $stmt = $this->pdo->prepare($sql);
                    $stmt->execute(['id' => $id]);

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row === false) break;

                    $id++; // Increment ID for the next query.
                    $textWords = explode(' ', $row['text']);
                    $rowWordCount = count($textWords);

                    if ($rowWordCount <= $remainingWords) {
                        $texts[] = $row['text'];
                        $remainingWords -= $rowWordCount;
                    } else {
                        $texts[] = implode(' ', array_slice($textWords, 0, $remainingWords));
                        break;
                    }

                } while ($remainingWords > 0);

                $text = implode(' ', $texts);
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
