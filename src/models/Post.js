export class Post {
    constructor(id, title, content, categories, author, date) {
        this.id = id;
        this.title = title;
        this.content = content;
        this.author = author;
        this.categories = categories;
        this.date = new Date(date);
    }
}