# QueryBuilder #

### Goals ###

- Easily build up large queries piece by piece based on conditional logic in PHP
- Prevent you from writing syntactically invalid SQL
- Prevent SQL injection by making it difficult *not* to escape something
- Write clauses in any order
- Easy integration with legacy projects
    - Work with any SQL driver, even the deprecated `mysql_` functions
    - Work with new or existing connections

### License ###

MIT