# xls2abralexi

Custom XLS Invoice Importer for AbraFlexi

[![wakatime](https://wakatime.com/badge/user/5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7/project/5de83ee4-0e40-4f93-a833-2d25484890ef.svg)](https://wakatime.com/badge/user/5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7/project/5de83ee4-0e40-4f93-a833-2d25484890ef)
[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Overview

`xls2abralexi` is a tool designed to import invoices from XLS files into the AbraFlexi accounting system. This utility simplifies the process of transferring invoice data, ensuring accuracy and efficiency.

## Features

- **Automated Import**: Automatically imports invoice data from XLS files into AbraFlexi.
- **Data Validation**: Validates the data to ensure it meets the required format and standards before importing.
- **Error Handling**: Provides detailed error messages and logs to help troubleshoot any issues during the import process.
- **Customizable**: Allows customization to fit specific business needs and requirements.

## Requirements

- PHP 7.x or higher
- AbraFlexi account and API access
- Required PHP libraries (listed in `composer.json`)

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/VitexSoftware/xls2abraflexi
    ```
2. Navigate to the project directory:
    ```sh
    cd xls2abralexi
    ```
3. Install the required dependencies:
    ```sh
    composer install
    ```

## Usage

1. Prepare your XLS file with the invoice data.
2. Run the import script:
    ```sh
    php import_invoices.php path/to/your/invoice_file.xls
    ```
3. Check the logs for any errors or confirmation of successful import.

## Configuration

You can configure the tool by editing the `.env` file. This file contains settings for connecting to the AbraFlexi API and other customizable options.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request with your changes.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

## Contact

For any questions or support, please open an issue on the GitHub repository or contact the maintainer at your.email@example.com.

## Thanks to Our Sponsor

Special thanks to our sponsor, [Utopia](https://utopia.cz/), for their support and contributions to this project.

![Project Logo](utopialibri.svg)

