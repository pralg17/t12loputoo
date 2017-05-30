from estnltk import Text
from pprint import pprint
from collections import Counter

# Matplotlib vajab töötamiseks läbi SSH matplotlib.use
import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt


# Eemaldab sisestatud sõnadest arvud, lausemärgid ja nimed.
# Tagastab DataFrame, ei eemaldata duplikaate.
def get_filtered_content(text):
	dataframe = Text(text).get(["word_texts", "lemmas", "postag_descriptions", "descriptions"]).as_dataframe
	filtered_dataframe = dataframe[(dataframe.postag_descriptions != "lausemärk") & (dataframe.descriptions != "") & (dataframe.lemmas != "") & (dataframe.word_texts != "") & (dataframe.postag_descriptions != "") & (dataframe.postag_descriptions != "pärisnimi") & dataframe.word_texts.apply(lambda sona: sona.isalpha())]
	return filtered_dataframe


# Loendab ära lemmade arve, tagastab kujul [("lemma", arv), ("lemma2", arv2), (... , ...)]
def count_lemmas(list_of_lemmas):
	c = Counter(list_of_lemmas)
	return c.most_common(100)


# Tagastab laisalt postagide arvu kaks korda.
# Salvestab samasse kausta piechard'i posttagide arvude kohta.
# Tight layout hoolitseb selle eest, et sildid mõõda ei läheks.
# Sort järiestab suuremast-väiksemani, head võtab välja viis esimest tulemust.
def make_postag_chart(dataframe):
	df1 = dataframe.groupby('postag_descriptions').size().reset_index(name='counts').sort_values("counts", ascending=False).head(5)
	plt.pie(df1["counts"], labels=None, shadow=False, startangle=90, autopct='%1.1f%%')
	plt.legend(df1["counts"], labels=df1["postag_descriptions"], loc="best")
	plt.savefig("t12loputoo/website/static/postags.png")
	plt.clf()  # Turvlisuse jaoks "puhasta kõik"
	
	
def wordform_chart(dataframe):
	df1 = dataframe.groupby('descriptions').size().reset_index(name='counts').sort_values("counts", ascending=False).head(5)
	plt.pie(df1["counts"], labels=None, shadow=False, startangle=90, autopct='%1.1f%%')
	plt.legend(df1["counts"], labels=df1["descriptions"], loc="best")
	plt.savefig("t12loputoo/website/static/word_forms.png")
	plt.clf()  # Turvlisuse jaoks "puhasta kõik"
