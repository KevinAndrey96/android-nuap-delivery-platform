using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace nuap.Views
{
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class ChoosePaymentMethodPage : ContentPage
    {
        public ChoosePaymentMethodPage()
        {
            InitializeComponent();
            NavigationPage.SetHasNavigationBar(this, false);
        }
    }
}