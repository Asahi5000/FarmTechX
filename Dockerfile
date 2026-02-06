# Base image with PHP CLI
FROM php:8.3-cli

# Set working directory
WORKDIR /app

# Copy all files into container
COPY . .

# Expose port 8080
EXPOSE 8080

# Start PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
