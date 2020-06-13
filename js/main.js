window.addEventListener('load', ()=>{
    toggleMobileNav();
    changeProvinceSelect();
});

const toggleMobileNav = () => {
    const header = document.querySelector('.main-header');
    const navToggleBtn = document.querySelector('.mobile-nav-toggle');
    if (header && navToggleBtn) {
        navToggleBtn.addEventListener('click', e => {
            e.preventDefault();
            header.classList.toggle('mobile-nav-visible');
        })
    }
}

// Obtengo las ciudades de una provincia, al seleccionarse en el formualrio de cliente
const changeProvinceSelect = () => {
    const provinceSelect = document.querySelector('#selectProvincias');
    const citySelect = document.querySelector('#selectLocalidades');

    if (provinceSelect && citySelect) {
        provinceSelect.addEventListener('change', e => {
            citySelect.setAttribute('disabled', true);
            fetch(`./api/get_province_cities.php?pid=${e.target.value}`)
            .then(response => response.json())
            .then(res => setCitySelect(res, citySelect))
            .catch(error => setCitySelect({success: false, error}, citySelect));
        });
    }
}
// Creo las opciones del selector de ciudad del formulario de cliente
const setCitySelect = (citiesRes, citySelect) => {
    let optionsList = [`<option selected hidden disabled>Seleccione una ciudad</option>`];
    if (citiesRes.success) {
        citiesRes.cities.forEach(city => optionsList.push(`<option value="${city.id}">${city.nombre}</option>`));
    } else {
        optionsList = [`<option selected hidden disabled>Error al obtener las ciudades</option>`];
        console.warn(citiesRes.error);
    }

    citySelect.innerHTML = optionsList.join('');
    citySelect.removeAttribute('disabled');
}