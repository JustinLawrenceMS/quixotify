
# Quixotify

Quixotify is a text generation library designed to retrieve and manipulate text excerpts from Miguel de Cervantes' *Don Quixote*. This library supports generating text based on characters, words, or sentences and includes functionalities to handle different output languages.

---

## Features

- Fetch random text excerpts from an SQLite database.
- Generate text by a specified number of characters, words, or sentences.
- Support for multiple languages (English and Spanish).
- Handles edge cases with missing or insufficient data.

---

## Installation

1. Clone the repository or include the classes in your project:
   ```bash
   git clone https://github.com/yourusername/quixotify.git
   ```
2. Ensure you have PHP 8.0+ and PDO SQLite installed.
3. Place your SQLite database (`database.db`) in the same directory as the `Controller` class.

---

## Classes Overview

### Controller

The `Controller` class is responsible for connecting to the database, validating input, and generating text.

#### Constructor
```php
$controller = new Controller("Spanish");
```
- **`$outputLanguage`**: Optional. Defaults to English (`"don_quixote_english_texts"`). Use `"Spanish"` for Spanish.

#### Public Methods
- **`generateText(string $unit, int $quantity): string`**  
  Generate text based on the unit (`characters`, `words`, or `sentences`) and quantity.

---

#### Public Methods
- **`generate(string $type, int $amount): string`**  
  Calls the `Controller` to generate text, with additional error handling.

---

## Usage

1. Initialize the `Controller` class:
   ```php
   use Quixotify\Controller;

   $controller = new Controller("Spanish"); // For Spanish texts
   ```

2. Generate text using the `Controller`:
   ```php
   $text = $controller->generateText('words', 50);
   echo $text;
   ```

3. Or, use the `Generator` class for better error handling:
   ```php
   use Quixotify\Generator;

   $controller = new Controller("Spanish");
   $generator = new Generator($controller);
   $text = $generator->generate('characters', 100);
   echo $text;
   ```

---

## Database Schema

The database should have the following schema:

| Column   | Type       | Description                |
|----------|------------|----------------------------|
| `id`     | INTEGER    | Primary key (auto-increment) |
| `text`   | TEXT       | The excerpt of text        |
| `word_count` | INTEGER | Number of words in the text |

Ensure the database has two tables:
1. `don_quixote_english_texts`
2. `don_quixote_spanish_texts`

---

## Error Handling

- **Invalid Input**: Throws exceptions if the input quantity is non-positive or the unit is invalid.
- **Insufficient Data**: Automatically fetches additional rows to meet the requested amount.

---

## Contributing

Contributions are welcome! Please submit a pull request or open an issue for bugs, features, or enhancements.

---

## License

This project is licensed under the MIT License. See the `LICENSE` file for details.
