# BinFinder

A Laravel application for fetching and caching BIN (Bank Identification Number) information using multiple providers. This project implements an adapter pattern to support various BIN lookup services and optimizes queries with caching.

## Features

- **Multiple BIN Providers**: Supports integration with multiple BIN lookup services.
- **Caching**: Caches BIN information to reduce the number of external API calls.
- **Flexible and Extensible**: Easily add or disable BIN providers.
- **RESTful API**: Expose endpoints for fetching BIN information and managing providers.
- **Database Seeding**: Pre-populates the database with initial provider data.
- **Unit and Feature Tests**: Comprehensive test coverage using Pest.

## Installation

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Perafan18/bin-finder.git
    ```

2. **Navigate to the project directory**:
    ```bash
    cd bin-finder
    ```

3. **Install dependencies**:
    ```bash
    ./vendor/bin/sail up -d
    ./vendor/bin/sail composer install
    ```

4. **Copy the example environment file and set up your environment variables**:
    ```bash
    cp .env.example .env
    ```

5. **Generate an application key**:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6. **Run the database migrations and seeders**:
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

## Configuration

Add your BIN lookup service API keys to the `.env` file:

```env
BIN_CODES_API_KEY=your_bincodes_api_key
BIN_CHECK_API_KEY=your_bincheck_api_key
GREIP_API_KEY=your_greip_api_key
IINLIST_API_KEY=your_iinlist_api_key
```

## Running the Application
Start the Laravel development server:

```bash
./vendor/bin/sail up
```

### Running Tests
Execute the test suite using Pest:

```bash
./vendor/bin/sail test
```

## Code Style and Linting
Run Laravel Pint to ensure code quality and consistency:

```bash
./vendor/bin/sail artisan pint
```

## Usage

The application exposes the following endpoints:

- `GET /api/bin/{bin}`: Fetch BIN information for the given BIN.
- `GET /api/providers`: List all BIN providers.
- `POST /api/providers/{provider}/toggle`: Enable or disable a BIN provider.

## Contributing

Contributions are welcome! Please submit issues or pull requests for improvements and bug fixes.

### Steps to Contribute

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes.
4. Commit your changes (`git commit -m 'Add new feature'`).
5. Push to the branch (`git push origin feature-branch`).
6. Open a pull request.

## License

This project is open-source and available under the MIT License.
