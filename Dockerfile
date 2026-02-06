# Use PHP CLI base image
FROM php:8.3-cli

# Set working directory
WORKDIR /app

# Copy all files into container
COPY . .

# Expose the port Wasmer will use
EXPOSE 8080

# Start PHP built-in server on all interfaces
CMD ["php", "-S", "0.0.0.0:8080", "-t", "."]
