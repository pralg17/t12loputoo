from django.shortcuts import render
from .backend import *
from .forms import InputForm


# Create your views here.
def index(request):
	form = InputForm()

	if request.method == "POST":
		df = get_filtered_content(request.POST.get("Tekst"))
		counted_lemmas = count_lemmas(df["lemmas"].tolist())
		make_postag_chart(df)
		wordform_chart(df)
		form = InputForm()
		return render(request, "website/index.html", {'form': form, 'lemmas': counted_lemmas})

	return render(request, "website/index.html", {'form': form})
