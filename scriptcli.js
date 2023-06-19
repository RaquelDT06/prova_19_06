const form = document.querySelector('#ClienteForms')
const nomeInput = document.querySelector('#nomeInput')
const sobrenomeInput = document.querySelector('#sobrenomeInput')
const tableBody = document.querySelector('#Clientetable tbody')

const URL = "http://localhost:8080/clientes.php"

function carregarClientes() {
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'

        },
        mode: "cors"
    })

        .then(response => response.json())
        .then(clientes => {
            tableBody.innerHTML = ''

            clientes.forEach(cliente => {
                const tr = document.createElement('tr')
                tr.innerHTML = `
        
        <td>${cliente.id_clientes}</td>
        <td>${cliente.nome}</td>
        <td>${cliente.sobrenome}</td>
        <td>
        <button data-id="${cliente.id_clientes}" onclick="atualizarcliente(${cliente.id_clientes})">Editar</button>
        <button onclick="excluircliente(${cliente.id_clientes})">Excluir</button>
        </td>
        `
                tableBody.appendChild(tr)

            })
        })
}

function adicionarcliente(event) {
    event.preventDefault()

    const nome = nomeInput.value
    const sobrenome = sobrenomeInput.value
    
    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'

        },
        body: `nome=${encodeURIComponent(nome)}&sobrenome=${encodeURIComponent(sobrenome)}`
    
    })

        .then(response => {
            if (response.ok) {
                carregarClientes()
                nomeInput.value = ''
                sobrenomeInput.value = ''
            } else {
                console.error('erro ao add cliente')
                alert('error ao add ')
            }

        })
}

function excluircliente(id_clientes) {
    if (confirm('Deseja excluir esse cliente?')) {
        fetch(`${URL}?id_clientes=${id_clientes}`, {
            method: 'DELETE'
        })

            .then(response => {
                if (response.ok) {
                    carregarClientes()
                } else {
                    console.error('Erro ao excluir')
                    alert('Error ao excluir')
                }
            })
    }
}

function atualizarcliente(id_clientes) {

    const novonome = prompt('Digite o nome')
    const novosobrenome = prompt('Digite o sobrenome')

    if (novonome && novosobrenome) {
        fetch(`${URL}?id_clientes=${id_clientes}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'

            },
            body: `nome=${encodeURIComponent(novonome)}&sobrenome=${encodeURIComponent(novosobrenome)}`
    
        })
            .then(response => {
                if (response.ok){
                    carregarClientes()
                }else{
                    console.error('Erro ao editar')
                    alert('Error ao editar cliente')
                }
            })


    }


}


form.addEventListener('submit', adicionarcliente)
carregarClientes()