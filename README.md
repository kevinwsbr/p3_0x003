# Well, what's SGPA?

SGPA is a fictional system of academic productivity management in PHP and created as the third project of the discipline of **Project of Software**. The demo can be viewed [here](kevinws.com.br/p3/sgpa).

## What an admin can do?

- Register new collabolators
- Add new projects/publications/orientations
- Change status of a project (in development/in progress/completed)
- Retrieve projects, publications and orientations of a user or the entire lab
- Generate an academic production report from the laboratory

## Dependencies

- MySQL Server 5.7
- PHP 7.0

## Right, and how to build that?

First, clone this repository. Open the repository folder and navigate to `docs/` and import `sgpa_cleaned.sql` file to your MySQL Server instance (note: the db was configured with default credentials (root/root) only for development purpouses). After that, navigate to `src/` folder and execute the PHP built-in server:

```bash
php -S localhost:<port>
```

Finally, open `localhost:<port>` on your browser.

OR SIMPLY CLICK [HERE](kevinws.com.br/p3/sgpa).

## License

This project is licensed under the MIT License.
