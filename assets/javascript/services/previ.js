export const getProducts = async () => {
    const response = await fetch('index.php?component=previ&action=products',
        {headers : {'X-Requested-With': 'XMLHttpRequest'}});
    return await response.json();
}