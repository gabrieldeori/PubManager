<?php
    namespace App\Helpers;

    class MSG
    {
        public const UNAUTHORIZED_ACCESS = "Acesso não autorizado";
        public const FORBIDDEN_ACCESS = "Acesso proibido";

        public const CLIENTS_CREATED = "Clientes criados";
        public const CLIENTS_NOT_CREATED = "Clientes não criados";
        public const CLIENTS_FOUND = "Clientes encontrados";
        public const CLIENTS_NOT_FOUND = "Nenhum cliente encontrado";
        public const CLIENT_NOT_FOUND = "Cliente não encontrado";
        public const CLIENT_UPDATED = "Cliente atualizado";
        public const CLIENT_NOT_UPDATED = "Cliente não atualizado";
        public const CLIENTS_DELETED = "Clientes deletados";
        public const CLIENTS_NOT_DELETED = "Clientes não deletados";
        public const CLIENTS_INVALID_FORMAT = "Formato inválido para clientes";

        public const USER_CREATED = "Usuário criado";
        public const USER_NOT_CREATED = "Usuário não criado";
        public const USER_FOUND = "Usuário encontrado";
        public const USERS_FOUND = "Usuários encontrados";
        public const USER_NOT_FOUND = "Usuário não encontrado";
        public const USERS_NOT_FOUND = "Nenhum usuário encontrado";
        public const USER_UPDATED = "Usuário atualizado";
        public const USER_NOT_UPDATED = "Usuário não atualizado";
        public const USER_DELETED = "Usuário deletado";
        public const USER_NOT_DELETED = "Usuário não deletado";
        public const USER_INVALID_FORMAT = "Formato inválido para usuário";

        public const LOGIN_SUCCESS = "Login realizado com sucesso";
        public const LOGIN_FAIL = "Login falhou";
        public const LOGOUT_SUCCESS = "Logout realizado com sucesso";
        public const LOGOUT_FAIL = "Logout falhou";
        public const LOGIN_REQUIRED = "Login necessário";
        public const LOGIN_INVALID = "Login inválido";
        public const LOGIN_INVALID_FORMAT = "Formato inválido para login";

        public const PASSWORD_NOT_MATCH = "Senha não confere";
        public const PASSWORD_MATCH = "Senha confere";
        public const PASSWORD_INVALID_FORMAT = "Formato inválido para senha";

        public const PRODUCT_CREATED = "Produto criado";
        public const PRODUCT_NOT_CREATED = "Produto não criado";
        public const PRODUCT_FOUND = "Produto encontrado";
        public const PRODUCTS_FOUND = "Produtos encontrados";
        public const PRODUCTS_NOT_FOUND = "Nenhum produto encontrado";
        public const PRODUCT_NOT_FOUND = "Produto não encontrado";
        public const PRODUCT_UPDATED = "Produto atualizado";
        public const PRODUCT_NOT_UPDATED = "Produto não atualizado";
        public const PRODUCT_DELETED = "Produto deletado";
        public const PRODUCT_NOT_DELETED = "Produto não deletado";
        public const PRODUCT_INVALID_FORMAT = "Formato inválido para produto";
        public const PRODUCTS_TABLE_EMPTY = "Tabela de produtos vazia";

        public const UNIT_CREATED = "Unidade criada";
        public const UNIT_NOT_CREATED = "Unidade não criada";
        public const UNIT_FOUND = "Unidade encontrada";
        public const UNITS_FOUND = "Unidades encontradas";
        public const UNITS_NOT_FOUND = "Nenhuma unidade encontrada";
        public const UNIT_NOT_FOUND = "Unidade não encontrada";
        public const UNIT_UPDATED = "Unidade atualizada";
        public const UNIT_NOT_UPDATED = "Unidade não atualizada";
        public const UNIT_DELETED = "Unidade deletada";
        public const UNIT_NOT_DELETED = "Unidade não deletada";
        public const UNIT_INVALID_FORMAT = "Formato inválido para unidade";
        public const UNITS_TABLE_EMPTY = "Tabela de unidades vazia";

        public const PURCHASE_CREATED = "Compra criada";
        public const PURCHASE_NOT_CREATED = "Compra não criada";
        public const PURCHASE_FOUND = "Compra encontrada";
        public const PURCHASES_FOUND = "Compras encontradas";
        public const PURCHASES_NOT_FOUND = "Nenhuma compra encontrada";
        public const PURCHASE_NOT_FOUND = "Compra não encontrada";
        public const PURCHASE_UPDATED = "Compra atualizada";
        public const PURCHASE_NOT_UPDATED = "Compra não atualizada";
        public const PURCHASE_DELETED = "Compra deletada";
        public const PURCHASE_NOT_DELETED = "Compra não deletada";
        public const PURCHASE_INVALID_FORMAT = "Formato inválido para compra";
        public const PURCHASES_TABLE_EMPTY = "Tabela de compras vazia";

        public const SALE_CREATED = "Venda criada";
        public const SALE_NOT_CREATED = "Venda não criada";
        public const SALE_FOUND = "Venda encontrada";
        public const SALES_FOUND = "Vendas encontradas";
        public const SALES_NOT_FOUND = "Nenhuma venda encontrada";
        public const SALE_NOT_FOUND = "Venda não encontrada";
        public const SALE_UPDATED = "Venda atualizada";
        public const SALE_NOT_UPDATED = "Venda não atualizada";
        public const SALE_DELETED = "Venda deletada";
        public const SALE_NOT_DELETED = "Venda não deletada";
        public const SALE_INVALID_FORMAT = "Formato inválido para venda";
        public const SALES_TABLE_EMPTY = "Tabela de vendas vazia";

        public const STOCK_CREATED = "Estoque criado";
        public const STOCK_NOT_CREATED = "Estoque não criado";
        public const STOCK_FOUND = "Estoque encontrado";
        public const STOCKS_FOUND = "Estoques encontrados";
        public const STOCKS_NOT_FOUND = "Nenhum estoque encontrado";
        public const STOCK_NOT_FOUND = "Estoque não encontrado";
        public const STOCK_UPDATED = "Estoque atualizado";
        public const STOCK_NOT_UPDATED = "Estoque não atualizado";
        public const STOCK_DELETED = "Estoque deletado";
        public const STOCK_NOT_DELETED = "Estoque não deletado";
        public const STOCK_INVALID_FORMAT = "Formato inválido para estoque";
        public const STOCKS_TABLE_EMPTY = "Tabela de estoques vazia";

        public const COMANDA_CREATED = "Comanda criada";
        public const COMANDA_NOT_CREATED = "Comanda não criada";
        public const COMANDA_FOUND = "Comanda encontrada";
        public const COMANDAS_FOUND = "Comandas encontradas";
        public const COMANDAS_NOT_FOUND = "Nenhuma comanda encontrada";
        public const COMANDA_NOT_FOUND = "Comanda não encontrada";
        public const COMANDA_UPDATED = "Comanda atualizada";
        public const COMANDA_NOT_UPDATED = "Comanda não atualizada";
        public const COMANDA_DELETED = "Comanda deletada";
        public const COMANDA_NOT_DELETED = "Comanda não deletada";
        public const COMANDA_INVALID_FORMAT = "Formato inválido para comanda";
        public const COMANDAS_TABLE_EMPTY = "Tabela de comandas vazia";

        public const SERVER_ERROR = "Erro no servidor";
        public const INVALID_DATA = "Dados inválidos";

        public const NOT_FOUND = 404;
        public const OK = 200;
        public const CREATED = 201;
        public const ACCEPTED = 202;
        public const INTERNAL_SERVER_ERROR = 500;
        public const BAD_REQUEST = 400;
        public const UNAUTHORIZED = 401;
        public const FORBIDDEN = 403;
        public const UNPROCESSABLE_ENTITY = 422;

        public const USER_VALIDATE = [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O nome não pode ter mais do que :max caracteres.',
            'name.regex' => 'O nome deve conter apenas letras e espaços em branco.',
            'nickname.required' => 'O apelido é obrigatório.',
            'nickname.min' => 'O apelido deve ter pelo menos :min caracteres.',
            'nickname.max' => 'O apelido não pode ter mais do que :max caracteres.',
            'nickname.regex' => 'O apelido deve conter apenas letras.',
            'email.required' => 'O endereço de e-mail é obrigatório.',
            'email.email' => 'O endereço de e-mail deve ser válido.',
            'password.min' => 'A senha deve ter pelo menos :min caracteres.',
            'password.max' => 'A senha não pode ter mais do que :max caracteres.',
            'userType.required' => 'O tipo de usuário é obrigatório.',
            'userType.in' => 'O tipo de usuário deve ser "Nenhum" ou "Admin".',
            'password_old.required' => 'A senha antiga é obrigatória.',
        ];

        public const PRODUCT_VALIDATE = [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos :min caracteres.',
            'name.max' => 'O nome não pode ter mais do que :max caracteres.',
            'name.regex' => 'O nome deve conter apenas letras e espaços em branco.',
            'description.required' => 'A descrição é obrigatória.',
            'description.min' => 'A descrição deve ter pelo menos :min caracteres.',
            'description.max' => 'A descrição não pode ter mais do que :max caracteres.',
            'description.regex' => 'A descrição deve conter apenas letras e espaços em branco.',
            'alcoholic.required' => 'O campo "alcoholic" é obrigatório.',
            'alcoholic.boolean' => 'O campo "alcoholic" deve ser "true" ou "false".',
            'preparable.required' => 'O campo "preparable" é obrigatório.',
            'preparable.boolean' => 'O campo "preparable" deve ser "true" ou "false".',
        ];

        public const PURCHASE_VALIDATE = [
            'product_id.required' => 'O id do produto é obrigatório.',
            'product_id.integer' => 'O id do produto deve ser um número inteiro.',
            'product_id.exists' => 'O id do produto deve existir na tabela de produtos.',
            'unit_id.required' => 'O id da unidade é obrigatório.',
            'unit_id.integer' => 'O id da unidade deve ser um número inteiro.',
            'unit_id.exists' => 'O id da unidade deve existir na tabela de unidades.',
            'quantity.required' => 'A quantidade é obrigatória.',
            'quantity.integer' => 'A quantidade deve ser um número inteiro.',
            'quantity.min' => 'A quantidade deve ser maior do que :min.',
            'quantity.max' => 'A quantidade deve ser menor do que :max.',
            'quantity.regex' => 'A quantidade deve ser um número inteiro.',
            'price.required' => 'O preço é obrigatório.',
            'price.numeric' => 'O preço deve ser um número.',
            'price.min' => 'O preço deve ser maior do que :min.',
            'price.max' => 'O preço deve ser menor do que :max.',
            'price.regex' => 'O preço deve ser um número.',
            'date.required' => 'A data é obrigatória.',
            'date.date' => 'A data deve ser uma data válida.',
            'date.date_format' => 'A data deve estar no formato "Y-m-d".',

        ];

        public const COMANDA_VALIDATE = [
            'client.required' => 'O id do cliente é obrigatório.',
            'client.integer' => 'O id do cliente deve ser um número inteiro.',
            'client.exists' => 'O id do cliente deve existir na tabela de clientes.',
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'description.required' => 'A descrição é obrigatória.',
            'description.string' => 'A descrição deve ser uma string.',
            'products.required' => 'Os produtos são obrigatórios.',
            'products.array' => 'Os produtos devem ser um array.',
            'products.min' => 'Os produtos devem ter pelo menos :min.',
            'products.*.id.required' => 'O id do produto é obrigatório.',
            'products.*.id.integer' => 'O id do produto deve ser um número inteiro.',
            'products.*.id.exists' => 'O id do produto deve existir na tabela de produtos.',
            'products.*.quantity.required' => 'A quantidade é obrigatória.',
            'products.*.quantity.numeric' => 'A quantidade deve ser um número.',
            'products.*.individualPrice.required' => 'O preço individual é obrigatório.',
            'products.*.individualPrice.numeric' => 'O preço individual deve ser um número.',
        ];
    }
?>
