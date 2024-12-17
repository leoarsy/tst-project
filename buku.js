async function getBooks() {
    const url = "http://localhost/Storage/books.json"; // Correct API URL
    try {
        const response = await fetch(url, {
            method: "GET",
            headers: {
                "auth": "PMAK-674a0524bb64a2000119d75a-12f8d445ca3dd4c9d841af4acf8706ffd0", // Include API key in header
            },
        });

        if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
        }

        const books = await response.json();
        displayBooks(books);
    } catch (error) {
        console.error("Error fetching books:", error.message);
    }
}

function displayBooks(books) {
    const bookList = document.getElementById('bookList');
    bookList.innerHTML = ''; // Clear the list before populating it

    books.forEach(book => {
        const bookItem = document.createElement('div');
        bookItem.className = 'book-item';
        bookItem.innerHTML = `
            <h3>${book.title}</h3>
            <p><strong>Author:</strong> ${book.author}</p>
            <p><strong>Year:</strong> ${book.year}</p>
        `;
        bookList.appendChild(bookItem);
    });
}

document.getElementById('loadBooks').addEventListener('click', getBooks);
