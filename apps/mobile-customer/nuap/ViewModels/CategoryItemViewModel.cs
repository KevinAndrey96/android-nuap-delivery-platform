namespace nuap.ViewModels
{
    using GalaSoft.MvvmLight.Command;
    using Models;
    using System.Windows.Input;
    using Xamarin.Forms;
    using Views;

    public class CategoryItemViewModel : Category
    {
        public ICommand GetCategoryProductsCommand
        {
            get
            {
                return new RelayCommand(GetCategoryProducts);
            }
        }

        private async void GetCategoryProducts()
        {
            var mainViewModel = MainViewModel.GetInstance();

            mainViewModel.CategoryProduct = new CategoryProductViewModel(this);

            await Application.Current.MainPage.Navigation.PopAsync();
            await Application.Current.MainPage.Navigation.PushAsync(new CategoryProductsPage());
        }
    }
}
