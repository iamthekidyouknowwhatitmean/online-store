<div class="container">
    <h1>Оформление заказа</h1>

    <form action="/checkout" method="POST">
        @csrf

        <div class="mb-3">
            <label>Имя*</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Телефон</label>
            <input type="text" name="customer_phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="customer_email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Адрес</label>
            <textarea name="address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Комментарий</label>
            <textarea name="comment" class="form-control"></textarea>
        </div>

        <h4>Итого:  ₽</h4>

        <button type="submit" class="btn btn-success mt-3">Оформить заказ</button>
    </form>
</div>
