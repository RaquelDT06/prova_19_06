const form = document.querySelector('#PedidoForms')
const nome_pratoInput = document.querySelector('#nome_pratoInput')
const clienteInput = document.querySelector('#clienteInput')
const quantidadeInput = document.querySelector('#quantidadeInput')
const precoInput = document.querySelector('#precoInput')
const tableBody = document.querySelector('#PedidoTabela tbody')

const URL = "http://localhost:8080/pedidos.php"

function carregarPedidos() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'

        },
        mode: "cors"
    })

        .then(response => response.json())
        .then(pedidos => {
            tableBody.innerHTML = ''

            pedidos.forEach(pedido => {
                const tr = document.createElement('tr')
                tr.innerHTML = `
        
        <td>${pedido.id_pedidos}</td>
        <td>${pedido.nome_prato}</td>
        <td>${pedido.cliente}</td>
        <td>${pedido.quantidade}</td>
        <td>${pedido.preco}</td>
        <td>
        <button data-id="${pedido.id_pedidos}" onclick="atualizarpedidos(${pedido.id_pedidos})">Editar</button>
        <button onclick="excluirpedidos(${pedido.id_pedidos})">Excluir</button>
        </td>
        `
                tableBody.appendChild(tr)

            })
        })
}

function adicionarpedido(event) {
    event.preventDefault()

    const nome_prato = nome_pratoInput.value
    const cliente = clienteInput.value
    const quantidade = quantidadeInput.value
    const preco = precoInput.value

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'

        },
        body: `nome_prato=${encodeURIComponent(nome_prato)}&cliente=${encodeURIComponent(cliente)}&quantidade=${encodeURIComponent(quantidade)}&preco=${encodeURIComponent(preco)}`
    
    })

        .then(response => {
            if (response.ok) {
                carregarPedidos()
                nome_pratoInput.value = ''
                clienteInput.value = ''
                quantidadeInput.value = ''
                precoInput.value = ''
            } else {
                console.error('erro ao add pedido')
                alert('error ao add ')
            }

        })
}

function excluirpedidos(id_pedidos) {
    if (confirm('Deseja excluir esse pedido?')) {
        fetch(`${URL}?id_pedidos=${id_pedidos}`, {
            method: 'DELETE'
        })

            .then(response => {
                if (response.ok) {
                    carregarPedidos()
                } else {
                    console.error('Erro ao excluir')
                    alert('Error ao excluir')
                }
            })
    }
}

function atualizarpedidos(id_pedidos) {

    const novonome_prato = prompt('Digite o prato')
    const novocliente = prompt('Digite o cliente')
    const novoquantidade = prompt('Digite a quantidade')
    const novopreco = prompt('Digite o preço total')

    if (novonome_prato && novocliente && novoquantidade && novopreco ) {
        fetch(`${URL}?id_pedidos=${id_pedidos}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'

            },
            body: `nome_prato=${encodeURIComponent(novonome_prato)}&cliente=${encodeURIComponent(novocliente)}&quantidade=${encodeURIComponent(novoquantidade)}&preco=${encodeURIComponent(novopreco)}`
    
        })
            .then(response => {
                if (response.ok){
                    carregarPedidos()
                }else{
                    console.error('Erro ao editar')
                    alert('Error ao editar pedido')
                }
            })


    }


}


form.addEventListener('submit', adicionarpedido)
carregarPedidos()