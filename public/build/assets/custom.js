// 3 seconds to remove success message

setTimeout(function () {
    let alert = document.getElementById('success-alert');
    if (alert) {
        alert.classList.remove('show');
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 500); // يتم حذفها نهائيًا بعد ما تختفي
    }
}, 3000); // بعد 3 ثواني


// order items page

let items = [];

function renderItems() {
    let html = '';
    let total = 0;

    items.forEach((item, index) => {
        let itemTotal = item.price * item.quantity;
        total += itemTotal;

        html += `
            <tr data-id="${item.id}">
                <td>
                    ${item.name}
                    <button class="btn btn-sm btn-danger float-end delete-item" data-index="${index}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
                <td>
                    <input type="number" value="${item.quantity}" min="1" data-index="${index}" class="form-control form-control-sm quantity-input">
                </td>
                <td data-price="${item.price}">${item.price}</td>
            </tr>
        `;
    });

    document.getElementById('order-items').innerHTML = html;
    document.getElementById('total-price').innerText = total;
}

window.addEventListener('DOMContentLoaded', function () {
    // لما تدوس على المنتج
    document.querySelectorAll('.product-item').forEach(card => {
        card.addEventListener('click', function () {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const price = parseFloat(this.dataset.price);

            const existing = items.find(i => i.id == id);
            if (existing) {
                existing.quantity++;
            } else {
                items.push({ id, name, price, quantity: 1 });
            }

            renderItems();
        });
    });

    // تعديل الكمية
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity-input')) {
            const index = e.target.dataset.index;
            const value = parseInt(e.target.value);

            if (value > 0) {
                items[index].quantity = value;
                renderItems();
            }
        }
    });

    // حذف منتج
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-item')) {
            const index = e.target.dataset.index;
            items.splice(index, 1);
            renderItems();
        }
    });
});

// عشان نبعته في الداتا بيز بالجافا سكريبت ليه استخدمناه
// عشان احنا مش عاملين فورم يبعت بيها الداتا احنا جايبينها من الجافا سكريبت و الصفحه مش بتعمل ريفريش

document.getElementById('save-order').addEventListener('click', function () {
    const orderItems = [];
    document.querySelectorAll('#order-items tr').forEach(row => {
        const productId = row.dataset.id;
        const name = row.querySelector('td:nth-child(1)').innerText;
        const price = parseFloat(row.querySelector('td[data-price]')?.dataset.price || 0);
        const quantity = row.querySelector('input').value;

        orderItems.push({
            id: productId,
            name: name,
            price: parseFloat(price),
            quantity: parseInt(quantity)
        });
    });

    const total = orderItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);

    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const customerId = document.getElementById('customer_id').value;


    fetch('/orders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            customer_id: customerId || null,
            items: orderItems,
            total: total,
        }),
    })
    .then(async response => {
        const text = await response.text();

        if (!response.ok) {
            throw new Error(text);
        }

        return JSON.parse(text);
    })
    .then(data => {
        alert(data.message);
        window.location.href = '/orders/' + data.order_id;
    })
    .catch(error => {
        console.error(error);
        alert(data.message);
    });
});

// Print order receipt
function printReceipt() {
    const printContents = document.getElementById('receipt').innerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

// live search of create order
document.addEventListener('DOMContentLoaded', function () {
    const input  = document.getElementById('search-products-input');
    const wrap   = document.getElementById('products-container');
    if (!input || !wrap) return; // أمان

    // رسالة لا توجد نتائج
    let emptyMsg = document.getElementById('no-results');
    if (!emptyMsg) {
        emptyMsg = document.createElement('div');
        emptyMsg.id = 'no-results';
        emptyMsg.className = 'py-4 text-center text-muted w-100';
        emptyMsg.style.display = 'none';
        emptyMsg.textContent = 'لا توجد منتجات مطابقة';
        wrap.appendChild(emptyMsg);
    }

    // تحويل الأرقام العربية/الهندية للاتينية عشان البحث يظبط
    const arabicDigitsMap = {'٠':'0','١':'1','٢':'2','٣':'3','٤':'4','٥':'5','٦':'6','٧':'7','٨':'8','٩':'9'};
    const toLatinDigits = (s) => (s || '').replace(/[٠-٩]/g, d => arabicDigitsMap[d]);

    const normalize = (s) => toLatinDigits(String(s || '').toLowerCase().trim());

    const filter = () => {
        const q = normalize(input.value);
        const items = wrap.querySelectorAll('.product-item');
        let shown = 0;

        items.forEach(el => {
            const hay =
                normalize(el.dataset.name) + ' ' +
                normalize(el.dataset.price) + ' ' +
                normalize(el.dataset.id);

            const match = q === '' || hay.includes(q);
            el.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        emptyMsg.style.display = shown ? 'none' : '';
    };

    // استخدم input بدل keyup عشان يشتغل مع اللصق والموبايل
    input.addEventListener('input', filter);

    // تشغيل مبدئي
    filter();
});
