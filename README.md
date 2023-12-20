# FloraFavs - Online Shop Website for Plant Products

FloraFavs is an online store that offers a variety of plant products. There are three types of users that can access this site, namely customers, administrators, and managers. Administrators and managers are considered as one type of user called internal users. To distinguish between administrators and managers, this site uses the concept of multi user in the internal user login process. The features contained in each actor are as follows:

- Customer
  - Customers can register a new account.
  - Customers can login using the account that has been created.
  - Customers can update their profile.
  - Customers can view a list of items sold in the online store with filters and search features.
  - Customers can add items to the cart.
  - Customers can update the items in the cart.
  - Customers can delete items in the cart.
  - Customers can make transactions.
  - Customers can change the transaction payment method.
- Administrator
  - Administrator can register a new account.
  - Administrator can login using the account that has been created.
  - Administrator can view customer data.
  - Administrator can view goods and supplier data.
  - Administrator can add goods and supplier data.
  - Administrator can update goods and supplier data.
  - Administrators can delete goods and supplier data.
- Manager
  - Managers can register a new account.
  - Managers can log in using the account that has been created.
  - Managers can view graphs, recaps, and total unpaid transactions with a certain time range.
  - Managers can view graphs, recaps, and total transactions that have been paid for a certain period of time.

## Table of Contents

- [Usage](#usage)
  - [Installation](#installation)
  - [Account Information for Login](#account-information-for-login)
  - [Token for Staff Registration](#token-for-staff-registration)
- [Support Me](#support-me)
- [License](#license)

## Usage

### Installation

1. Clone this repository to your computer (if you are using XAMPP, place the clone in the `htdocs` folder):

   ```bash
   git clone https://github.com/shafygunawan/florafavs.git
   ```

2. Create a new database with the name `store`, then import the `dump.sql` file into the database.

3. Next, you need to set up the configuration in this project. Open the `config/database.php` file and set the global variables `DB_NAME`, `DB_USERNAME`, and `DB_PASSWORD` according to the configuration you are using, as shown below:

   ```php
   define('DB_NAME', 'store');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', '');
   ```

4. To access this website, type the following address into a web browser: `http://localhost/florafavs`.

### Account Information for Login

The following account information can be used to log in as a customer:

| Name               | Email              | Password     |
| ------------------ | ------------------ | ------------ |
| Shafy Gunawan      | shafy@example.com  | Password@123 |
| Naufal Alifiansyah | naufal@example.com | Password@123 |

The following account information can be used to log in as staff:

| Name         | Email             | Password     | Role          |
| ------------ | ----------------- | ------------ | ------------- |
| Andre Eka    | andre@example.com | Password@123 | Administrator |
| Umar Muchtar | umar@example.com  | Password@123 | Manager       |

### Token for Staff Registration

The following are the tokens used for new staff registration:

| Token  | Role          |
| ------ | ------------- |
| 2s93kl | Administrator |
| 943il2 | Manager       |

## Support Me

If you find this project useful and would like to support me, you can <a href="https://www.buymeacoffee.com/shafygunawan" target="_blank">Buy Me a Coffee</a>.

## License

This project is licensed under the MIT License. More details can be found in the [LICENSE](https://github.com/shafygunawan/florafavs/blob/main/LICENSE) file.

Thank you for visiting this project!

_Notes:_

- _You can only view without making changes to this repo website with the url [https://shafygunawan.my.id/projects/florafavs](https://shafygunawan.my.id/projects/florafavs)._
- _This project was built to fulfill a lecture assignment and was done in groups._
