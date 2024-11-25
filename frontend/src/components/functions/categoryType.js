export const Categories = (products) => {
    let categories = ["ALL"];
    products.forEach((element) => {
      if (element.category && !categories.includes(element.category)) {
        categories.push(element.category);
      }
    });
  
    return categories;
  };