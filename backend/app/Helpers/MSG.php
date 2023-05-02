<?php
    namespace App\Helpers;

    class MSG
    {
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

        public const PRODUCTS_CREATED = "Produtos criados";
        public const PRODUCTS_NOT_CREATED = "Produtos não criados";
        public const PRODUCTS_FOUND = "Produtos encontrados";
        public const PRODUCTS_NOT_FOUND = "Nenhum produto encontrado";
        public const PRODUCT_NOT_FOUND = "Produto não encontrado";
        public const PRODUCT_UPDATED = "Produto atualizado";
        public const PRODUCT_NOT_UPDATED = "Produto não atualizado";
        public const PRODUCTS_DELETED = "Produto deletado";
        public const PRODUCT_NOT_DELETED = "Produto não deletado";
        public const PRODUCT_INVALID_FORMAT = "Formato inválido para produto";


        public const SERVER_ERROR = "Erro no servidor";
        public const INVALID_DATA = "Dados inválidos";

        public const NOT_FOUND = 404;
        public const OK = 200;
        public const CREATED = 201;
        public const ACCEPTED = 202;
        public const INTERNAL_SERVER_ERROR = 500;
        public const BAD_REQUEST = 400;

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
    }
?>
