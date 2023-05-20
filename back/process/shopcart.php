<?php

/**
 * Get all products
 * @param $db
 * @return void
 */
function add($db): void
{
    if (isset($_POST['token']) && $_POST['token'] != "")
    {
        $token = $_POST['token'];
        $query = null;
        try
        {
            $query = $db->prepare('SELECT * FROM users WHERE token = :token');
            $query->execute([
                'token' => $token
            ]);
        }
        catch (PDOException $e)
        {
            display_response("error", $e->getMessage(), 500);
        }

        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user)
        {
            unset($user['password']);
            display_response("error", "User not found. Please reconnect", 404);
        }

        // Add to shopcart table
        if (isset($_POST['product_id']) && $_POST['product_id'] != "")
        {
            $product_id = $_POST['product_id'];
            $query = null;
            try
            {
                $query = $db->prepare('INSERT INTO shopping_cart (user_id, product_id) VALUES (:user_id, :product_id)');
                $query->execute([
                    'user_id' => $user['id'],
                    'product_id' => $product_id
                ]);
            }
            catch (PDOException $e)
            {
                display_response("error", $e->getMessage(), 500);
            }

            display_response("success", "Product added to shopcart.", 200);
        }
        else
        {
            display_response("error", "Product id missing.", 403);
        }
    }
    else
    {
        display_response("error", "Token missing. Please reconnect.", 403);
    }
}

/**
 * Remove a product from shopcart
 * @param $db
 * @return void
 */
function remove($db): void
{
    if (isset($_POST['token']) && $_POST['token'] != "")
    {
        $token = $_POST['token'];
        $query = null;
        try
        {
            $query = $db->prepare('SELECT * FROM users WHERE token = :token');
            $query->execute([
                'token' => $token
            ]);
        }
        catch (PDOException $e)
        {
            display_response("error", $e->getMessage(), 500);
        }

        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user)
        {
            unset($user['password']);
            display_response("error", "User not found. Please reconnect", 404);
        }

        // Remove from shopcart table
        if (isset($_POST['product_id']) && $_POST['product_id'] != "")
        {
            $product_id = $_POST['product_id'];
            $query = null;
            try
            {
                $query = $db->prepare('DELETE FROM shopping_cart WHERE user_id = :user_id AND product_id = :product_id');
                $query->execute([
                    'user_id' => $user['id'],
                    'product_id' => $product_id
                ]);
            }
            catch (PDOException $e)
            {
                display_response("error", $e->getMessage(), 500);
            }

            display_response("success", "Product removed from shopcart.", 200);
        }
        else
        {
            display_response("error", "Product id missing.", 403);
        }
    }
    else
    {
        display_response("error", "Token missing. Please reconnect.", 403);
    }
}

/**
 * Validate the shopping cart - TODO
 * @param $db
 * @return void
 */
function validate($db): void
{
    if (isset($_POST['token']) && $_POST['token'] != "")
    {
        $token = $_POST['token'];
        $query = null;
        try
        {
            $query = $db->prepare('SELECT * FROM users WHERE token = :token');
            $query->execute([
                'token' => $token
            ]);
        }
        catch (PDOException $e)
        {
            display_response("error", $e->getMessage(), 500);
        }

        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user)
        {
            unset($user['password']);
            display_response("error", "User not found. Please reconnect", 404);
        }
        // TO DO : Buy the shopping cart following instructions in project description
    }
    else
    {
        display_response("error", "Token missing. Please reconnect.", 403);
    }
}

/**
 * Get all products in shopcart
 * @param $db
 * @return void
 */
function get($db): void
{
    if (isset($_POST['token']) && $_POST['token'] != "")
    {
        $token = $_POST['token'];
        $query = null;
        try
        {
            $query = $db->prepare('SELECT * FROM users WHERE token = :token');
            $query->execute([
                'token' => $token
            ]);
        }
        catch (PDOException $e)
        {
            display_response("error", $e->getMessage(), 500);
        }

        $user = $query->fetch(PDO::FETCH_ASSOC);
        if (!$user)
        {
            unset($user['password']);
            display_response("error", "User not found. Please reconnect", 404);
        }

        // Get all products from shopcart table
        $query = null;
        try
        {
            $query = $db->prepare('SELECT products.name as name, products.price as price, products.image as image, products.description as description, products.id as id, categories.name as category FROM shopping_cart INNER JOIN products ON shopping_cart.product_id = products.id INNER JOIN categories ON products.category_id = categories.id WHERE shopping_cart.user_id = :user_id');
            $query->execute([
                'user_id' => $user['id']
            ]);
        }
        catch (PDOException $e)
        {
            display_response("error", $e->getMessage(), 500);
        }

        $shopcart = $query->fetchAll(PDO::FETCH_ASSOC);
        if (!$shopcart)
        {
            display_response("success", "Shopcart empty.", 200);
        }

        $products = [];
        foreach ($shopcart as $product)
        {
            $products[] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['image'],
                'description' => $product['description'],
                'category' => $product['category']
            ];
        }

        display_response("success", $products, 200);
    }
    else
    {
        display_response("error", "Token missing. Please reconnect.", 403);
    }
}