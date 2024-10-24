<?php

class Book
{
    private string $title;
    private string $author;
    private string $year;
    private string $active;

    /**
     * @param string $title
     * @param string $author
     * @param int $year
     * @param bool $active
     */
    public function __construct(string $title, string $author, int $year, bool $active)
    {
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->active = $active;
    }

    /**
     * @return object
     */
    public function getInfo(): object
    {
        return (object)[
            'title' => $this->title,
            'author' => $this->author,
            'active' => $this->active,
            'publicised' => $this->year
        ];
    }

}

class Library
{
    private array $books = [];

    /**
     * @param Book $book
     * @return void
     */
    public function addBook(Book $book): void
    {
        $this->books[] = $book;
        $info = $book->getInfo();

        echo "Book \"" . $info->title . "\" by \"" . $info->author . "\" added to the library.\n";
    }

    /**
     * @param $title
     * @return mixed
     */
    public function findBook($title): mixed
    {
        foreach ($this->books as $book) {
            $info = $book->getInfo();
            if ($info->title == $title) {
                return $info;
            }
        }
        return 'Not Found';
    }

    /**
     * @return array
     */
    public function listAvailableBooks(): array
    {
        $books_active = [];
        foreach ($this->books as $book) {
            $info = $book->getInfo();
            $info->active ? $books_active[] = $info : null;
        }

        return $books_active;
    }

    /**
     * @param string $title
     * @param bool $visible
     * @return void
     */
    public function changeVisibility(string $title, bool $visible): void
    {
        foreach ($this->books as $book) {
            $info = $book->getInfo();

            if ($info->title == $title) {
                if ($info->active == $visible) {
                    echo "\nBook is " . ($visible ? 'still available' : 'already taken');
                    return;
                }

                $info->active = $visible;
                echo "\nStatus was changed to " . ($visible ? 'available' : 'taken');
                return;
            }
        }

        echo "\nBook not found.";
    }

}

$library = new Library();

$book1 = new Book("The Great Gatsby", "F. Scott Fitzgerald", 1925, true);
$book2 = new Book("1984", "George Orwell", 1949, false);
$book3 = new Book("To Kill a Mockingbird", "Harper Lee", 1960, true);

$library->addBook($book1);
$library->addBook($book2);
$library->addBook($book3);

$foundBook = $library->findBook("To Kill a Mockingbird");
if (is_object($foundBook)) {
    echo "\nFound book --> " . $foundBook->title . " by " . $foundBook->author . ". Book is " . ($foundBook->active === true ? 'in library' : 'not in library, sorry.') . "\n";
} else {
    echo $foundBook . "\n";
}

$available = $library->listAvailableBooks();
if (!empty($available)) {
    echo "\n<--Available books-->\n";
    foreach ($available as $book) {
        echo "\"" . $book->title . "\" by " . $book->author . "\n";
    }
} else {
    echo "\nNo available books.\n";
}

$library->changeVisibility("To Kill a Mockingbird", true);
